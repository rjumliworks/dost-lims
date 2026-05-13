<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'reference_id',
        'amount',
        'currency',
        'status',
        'provider',
        'checkout_session_id',
        'payment_intent_id',
        'paid_at',
        'raw_response',
    ];

    protected $casts = [
        'raw_response' => 'array',
        'paid_at' => 'datetime',
    ];

    // 🔁 STATUS HELPERS
    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function markAsFailed()
    {
        $this->update([
            'status' => 'failed',
        ]);
    }

    public function markAsPending()
    {
        $this->update([
            'status' => 'pending',
        ]);
    }

    // 🔗 SCOPES
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
