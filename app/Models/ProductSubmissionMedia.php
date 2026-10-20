<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProductSubmissionMedia extends Model
{
    protected $table = 'product_submission_media';

    protected $fillable = ['submission_id', 'media_type', 'file_path'];

    public function submission(): BelongsTo
    {
        return $this->belongsTo(ProductSubmission::class, 'submission_id');
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }
}
