<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /** Halaman profil milik user yang sedang login. */
    public function show(Request $request): View
    {
        $user = $request->user();

        // Riwayat ulasan yang pernah ditulis (relasi User -> Review).
        $reviews = $user->reviews()
            ->with('product:id,name,slug')
            ->latest()
            ->take(10)
            ->get();

        return view('profile.show', compact('user', 'reviews'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'string', 'lowercase', 'email', 'max:255',
                          Rule::unique('users', 'email')->ignore($user->id)],
            'phone'   => ['nullable', 'string', 'regex:/^[0-9+\-\s()]{8,30}$/'],
            'address' => ['nullable', 'string', 'max:1000'],

            // Ganti password bersifat opsional.
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password'         => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'phone.regex'                       => 'Nomor telepon hanya boleh berisi angka, spasi, +, -, dan tanda kurung (8-30 karakter).',
            'current_password.required_with'    => 'Masukkan password saat ini untuk mengganti password.',
            'current_password.current_password' => 'Password saat ini salah.',
        ]);

        // Hanya field ini yang boleh diubah dari form. 'role' tidak pernah disentuh.
        $user->fill(Arr::only($data, ['name', 'email', 'phone', 'address']));

        if (! empty($data['password'])) {
            $user->password = $data['password']; // di-hash otomatis oleh cast 'hashed' di model User
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }
}