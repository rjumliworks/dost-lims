<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationSignatory extends Model
{
    protected $fillable = [
        'prepared_by',
        'prepared_date',
        'approved_by',
        'approved_date',
        'received_by',
        'received_date',
        'is_completed'
    ];

    public function prepared()
    {
        return $this->belongsTo('App\Models\User', 'prepared_by', 'id');
    }

    public function received()
    {
        return $this->belongsTo('App\Models\User', 'received_by', 'id');
    }

    public function approved()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

}
