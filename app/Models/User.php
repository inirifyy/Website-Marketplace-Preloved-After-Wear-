<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/*
 * 'role' SENGAJA tidak dimasukkan ke Fillable.
 * Kalau role bisa diisi lewat mass assignment, siapa pun bisa menjadikan
 * dirinya admin dengan mengirim field "role" lewat form. Role default
 * 'buyer' diberikan oleh database; seller/admin diatur lewat seeder atau
 * tinker, bukan lewat form publik.
 */
#[Fillable(['name', 'email', 'password', 'phone', 'address'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_BUYER  = 'buyer';
    public const ROLE_SELLER = 'seller';
    public const ROLE_ADMIN  = 'admin';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ---------- Relasi ----------

    /** Ulasan yang DITULIS user ini (kolom reviews.reviewer_id). */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }

    /** Produk milik user ini sebagai penjual (kolom products.seller_id). */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /** Pengajuan produk milik user ini sebagai penjual. */
    public function submissions(): HasMany
    {
        return $this->hasMany(ProductSubmission::class, 'seller_id');
    }

    // ---------- Helper role (dipakai controller, view, dan RoleMiddleware) ----------

    public function isBuyer(): bool
    {
        return $this->role === self::ROLE_BUYER;
    }

    public function isSeller(): bool
    {
        return $this->role === self::ROLE_SELLER;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /** Nama peran dalam Bahasa Indonesia untuk ditampilkan di halaman. */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN  => 'Admin',
            self::ROLE_SELLER => 'Penjual',
            default           => 'Pembeli',
        };
    }
}