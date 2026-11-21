<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\PhoneOtpService;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    /** Pilihan "Masuk sebagai" di halaman login. */
    public const LOGIN_ROLES = [
        User::ROLE_BUYER  => 'Pembeli',
        User::ROLE_SELLER => 'Penjual',
        User::ROLE_ADMIN  => 'Admin',
    ];

    /**
     * Tampilkan halaman formulir login.
     * /login?as=admin atau ?as=seller memilih tab peran lebih dulu.
     */
    public function showLogin(Request $request)
    {
        if (Auth::check()) {
            return redirect(Auth::user()->homeUrl());
        }

        $as = $request->query('as');
        $loginAs = array_key_exists($as, self::LOGIN_ROLES) ? $as : User::ROLE_BUYER;

        return view('auth.login', ['roles' => self::LOGIN_ROLES, 'loginAs' => $loginAs]);
    }

    /**
     * Alias method untuk showLoginForm.
     */
    public function showLoginForm(Request $request)
    {
        return $this->showLogin($request);
    }

    /**
     * Proses autentikasi login pengguna.
     * Tab peran (login_as) harus cocok dengan peran akun; keamanan sebenarnya
     * tetap dijaga middleware role di routes/web.php.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'login_as' => ['required', Rule::in(array_keys(self::LOGIN_ROLES))],
        ], [
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'login_as.required' => 'Pilih masuk sebagai Pembeli, Penjual, atau Admin.',
            'login_as.in'       => 'Pilihan peran tidak valid.',
        ]);

        $loginAs  = $credentials['login_as'];
        $remember = $request->boolean('remember');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            if ($user->role !== $loginAs) {
                $actual = self::LOGIN_ROLES[$user->role] ?? $user->role;
                $chosen = self::LOGIN_ROLES[$loginAs];

                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('login', ['as' => $user->role])
                    ->withErrors(['email' => "Akun ini terdaftar sebagai {$actual}, bukan {$chosen}. Pilih tab \"{$actual}\" untuk masuk."])
                    ->withInput(['email' => $credentials['email']]);
            }

            $request->session()->regenerate();

            $welcome = $user->isAdmin() ? 'Selamat datang kembali, Administrator!' : 'Selamat datang kembali, ' . $user->name . '!';

            // Penjual/pembeli yang nomornya belum diverifikasi diarahkan ke halaman verifikasi.
            if (! $user->isAdmin() && ! $user->hasVerifiedPhone()) {
                return redirect()->route('phone.verification.notice')
                    ->with('success', $welcome . ' Satu langkah lagi: verifikasi nomor HP Anda.');
            }

            return redirect()->intended($user->homeUrl())->with('success', $welcome);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email', 'login_as');
    }

    /**
     * Tampilkan halaman pendaftaran akun baru.
     * /register?as=seller memilih "Penjual" lebih dulu.
     */
    public function showRegister(Request $request)
    {
        if (Auth::check()) {
            return redirect(Auth::user()->homeUrl());
        }

        $as = $request->query('as') === User::ROLE_SELLER ? User::ROLE_SELLER : User::ROLE_BUYER;

        return view('auth.register', ['registerAs' => $as]);
    }

    /**
     * Alias method untuk showRegistrationForm.
     */
    public function showRegistrationForm(Request $request)
    {
        return $this->showRegister($request);
    }

    /**
     * Proses registrasi pengguna baru.
     * Admin TIDAK bisa dibuat dari sini: hanya buyer atau seller yang diterima.
     */
    public function register(Request $request, PhoneOtpService $otp)
    {
        // Samakan format nomor (0812..., +62812... -> 62812...) sebelum divalidasi.
        $request->merge(['phone' => Phone::normalize($request->input('phone'))]);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role'     => ['required', Rule::in([User::ROLE_BUYER, User::ROLE_SELLER])],
            'phone'    => ['required', 'regex:' . Phone::PATTERN, 'unique:users,phone'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email ini sudah terdaftar. Silakan login atau gunakan email lain.',
            'role.required'      => 'Pilih daftar sebagai Pembeli atau Penjual.',
            'role.in'            => 'Peran yang dipilih tidak valid.',
            'phone.required'     => 'Nomor HP / WhatsApp wajib diisi untuk verifikasi.',
            'phone.regex'        => 'Nomor HP tidak valid. Contoh: 081234567890.',
            'phone.unique'       => 'Nomor HP ini sudah dipakai akun lain.',
            'password.required'  => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'password.min'       => 'Kata sandi minimal terdiri dari 8 karakter.',
        ]);

        $user = new User([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // di-hash otomatis oleh cast 'hashed'
            'phone'    => $validated['phone'],
        ]);
        // 'role' tidak ada di $fillable (sengaja), jadi diisi langsung dari nilai yang sudah divalidasi.
        $user->role = $validated['role'];
        $user->save();

        Auth::login($user);
        $request->session()->regenerate();

        // Kirim kode OTP ke nomor HP, lalu arahkan ke halaman verifikasi.
        $result = $otp->issue($user);

        $redirect = redirect()->route('phone.verification.notice')
            ->with('success', 'Akun Anda berhasil dibuat! Verifikasi nomor HP untuk mulai menggunakan After Wear.');

        if (! $result['ok']) {
            $redirect->with('error', $result['error']);
        }
        if (isset($result['dev_code'])) {
            $redirect->with('dev_code', $result['dev_code']);
        }

        return $redirect;
    }

    /**
     * Keluar dari sesi login (logout).
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
