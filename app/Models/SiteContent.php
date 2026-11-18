<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'key',
        'title',
        'subtitle',
        'content',
        'image',
        'button_text',
        'button_url',
        'is_active',
        'order',
        'metadata',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'order' => 'integer',
            'metadata' => 'array',
        ];
    }

    /**
     * Scope query to active contents.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope query to a specific section.
     */
    public function scopeSection($query, string $section)
    {
        return $query->where('section', $section)->orderBy('order', 'asc');
    }

    /**
     * Helper to get active contents for a section ordered.
     */
    public static function getSection(string $section)
    {
        return static::active()->section($section)->get();
    }

    /**
     * Helper to get a specific content by key.
     */
    public static function getByKey(string $key, $default = null)
    {
        $item = static::active()->where('key', $key)->first();
        return $item ?? $default;
    }
}
