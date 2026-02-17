<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AgencyConfiguration extends Model
{
    protected $casts = [
        'laboratories' => 'array',
        'form' => 'array',
        'contact' => 'array',
    ];

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            $user = Auth::user();
            if ($user->hasRole('Administrator')) {
                return;
            }
            $agencyId = $user->profile?->agency_id;
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId);
        });
    }
    
    protected $fillable = [
        'laboratories','form','contact','samplecode_year','show_others','strict_mode','agency_id'
    ];

    public function agency()
    {
        return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');
    }

    public function getLaboratoriesAttribute($value)
    {
        return json_decode($value, true); 
    }

    public function getFormAttribute($value)
    {
        return is_string($value) ? json_decode($value, true) : $value;
    }
}
