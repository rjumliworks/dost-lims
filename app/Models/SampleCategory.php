<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SampleCategory extends Model
{
    protected $fillable = [
        'name', 'is_active', 'laboratory_id'
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

    public function types(){ return $this->hasMany(SampleType::class, 'category_id'); }
    public function laboratory(){ return $this->belongsTo(ListLaboratory::class, 'laboratory_id'); }
    public function agency(){ return $this->belongsTo(Agency::class, 'agency_id'); }
    public function user(){ return $this->belongsTo(User::class, 'user_id'); }

    public function getUpdatedAtAttribute($value) { return date('M d, Y g:i a', strtotime($value));}
    public function getCreatedAtAttribute($value){ return date('M d, Y g:i a', strtotime($value));}

}
