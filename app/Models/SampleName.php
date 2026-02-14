<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SampleName extends Model
{
    protected $fillable = [
        'name', 'type_id', 'is_active'
    ];

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            $agencyId = Auth::user()->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId);
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $model->user_id = $user->id;

                if (empty($model->agency_id)) {
                    $model->agency_id = $user->profile?->agency_id;
                }
            }
        });
    }

    public function sampleable(){ return $this->morphTo(); }
    public function type(){ return $this->belongsTo(SampleType::class, 'type_id'); }
    public function agency(){ return $this->belongsTo(Agency::class, 'agency_id'); }
    public function user(){ return $this->belongsTo(User::class, 'user_id'); }

       public function services()
    {
        return $this->morphMany('App\Models\TestserviceSample', 'sampleable');
    }

    public function getUpdatedAtAttribute($value) { return date('M d, Y g:i a', strtotime($value));}
    public function getCreatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}
}
