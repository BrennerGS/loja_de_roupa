<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'event',
        'old_data',
        'new_data',
        'description',
        'user_id',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
        'created_at' => 'datetime:d/m/Y H:i:s',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function model()
    {
        return $this->morphTo();
    }

    public function causer()
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
}
