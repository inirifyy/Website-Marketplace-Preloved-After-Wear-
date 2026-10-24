<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    /*
     * reviewer_id diisi dari user yang login di controller, BUKAN dari
     * input form, supaya orang tidak bisa menulis ulasan atas nama orang lain.
     */
    protected $fillable = ['product_id', 'reviewer_id', 'rating', 'comment'];

    protected function casts(): array
    {
        return ['rating' => 'integer'];
    }

    // ---------- Relasi ----------

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /** Pembeli yang menulis ulasan (kolom reviewer_id, bukan user_id). */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}