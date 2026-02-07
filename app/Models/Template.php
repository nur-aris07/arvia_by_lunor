<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Template extends Model
{
    protected $table = 'templates';
    public const UPDATED_AT = null;
    protected $fillable = [
        'name',
        'slug',
        'price',
        'preview_image',
        'description',
        'is_active',
    ];

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

    public function scopeActive($query) {
        return $query->where('is_active', 1);
    }
}
