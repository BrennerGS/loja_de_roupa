<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaPost extends Model
{
    protected $fillable = [
        'platform', 'post_type', 'status', 'publish_at',
        'image', 'caption', 'metrics', 'user_id'
    ];

    protected $casts = [
        'publish_at' => 'datetime',
        'metrics' => 'array',
        'created_at' => 'datetime:d/m/Y H:i',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getPlatformIconAttribute(): string
    {
        return [
            'instagram' => 'fab fa-instagram',
            'facebook' => 'fab fa-facebook',
            'twitter' => 'fab fa-twitter',
            'tiktok' => 'fab fa-tiktok',
        ][$this->platform] ?? 'fas fa-share-alt';
    }
}
