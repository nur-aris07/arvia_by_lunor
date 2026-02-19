<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Payment extends Model
{
    protected $table = 'payments';
    public const UPDATED_AT = null;
    protected $fillable = [
        'invitation_id',
        'invoice_number',
        'amount',
        'payment_method',
        'paid_at',
        'notes',
    ];

    public function getHashIdAttribute(): string {
        return Crypt::encryptString($this->id);
    }

    public function invitation() {
        return $this->belongsTo(Invitation::class);
    }

}
