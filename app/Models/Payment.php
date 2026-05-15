<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'method',
        'subtotal',
        'fee',
        'total',
        'amount',
        'status',
        'payload',
        'checkout_session_id',
        'payment_intent_id',
        'paid_at',
        'tsr_id',
        'reference_number'
    ];

     public function tsr()
    {
        return $this->belongsTo('App\Models\Tsr', 'tsr_id', 'id');
    }

    protected $casts = [
        'payload' => 'array',
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
