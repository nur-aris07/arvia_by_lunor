<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Invitation extends Model
{
    protected $table = 'invitations';
    public const UPDATED_AT = null;
    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'slug',
        'status',
        'payment_status',
    ];

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function template() {
        return $this->belongsTo(Template::class);
    }

}
