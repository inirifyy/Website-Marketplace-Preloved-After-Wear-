<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'slug', 'description', 'price',
        'item_condition', 'material', 'usage_duration', 'flaws', 'location',
        'status', 'approval_status',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

    // ---------- Relasi ----------
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    // ---------- Scope: dipakai katalog publik ----------
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('approval_status', 'approved');
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->where('status', 'ready');
    }

    // ---------- Helper untuk view ----------
    /** URL foto pertama; kalau tidak ada, pakai placeholder. */
    public function getCoverUrlAttribute(): string
    {
        $image = $this->media->firstWhere('media_type', 'image');

        return $image
            ? Storage::url($image->file_path)
            : asset('images/placeholders/product-placeholder.jpg');
    }

    /** Buat slug unik, contoh: "kemeja-flanel", "kemeja-flanel-2", ... */
    public static function makeUniqueSlug(string $name): string
    {
        $base = Str::slug($name) ?: 'produk';
        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
