<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class TestserviceSample extends Model
{
    protected $fillable = ['testservice_id', 'sampleable_id', 'sampleable_type'];
    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->added_by = $user->id;
            }
        });
    }

    public function sampleable()
    {
        return $this->morphTo();
    }

    public function category()
    {
        return $this->belongsTo(SampleCategory::class);
    }
}
