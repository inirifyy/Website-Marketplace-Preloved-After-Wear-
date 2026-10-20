<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductSubmission extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'description', 'price',
        'item_condition', 'material', 'usage_duration', 'flaws', 'location',
        'contact_whatsapp', 'submission_status', 'admin_note',
    ];

    protected function casts(): array
    {
        return ['price' => 'decimal:2'];
    }

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
        return $this->hasMany(ProductSubmissionMedia::class, 'submission_id');
    }
}
