<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FinanceSequence extends Model
{
    protected $fillable = ['next_sequence', 'year', 'facility_id', 'agency_id'];

    public static function getNextCode()
    {
        return \DB::transaction(function () {
            $user = Auth::user();
            $agencyId = $user->profile?->agency_id;
            $facilityId = $user->profile?->facility_id;
            $year = date('Y');
            
            $sequence = FinanceSequence::where([
                'agency_id' => $agencyId,
                'facility_id' => $facilityId,
                'year' => $year
            ])->lockForUpdate()->first();

            if (!$sequence) {
                $sequence = FinanceSequence::create([
                    'agency_id' => $agencyId,
                    'facility_id' => $facilityId,
                    'year' => $year,
                    'next_sequence' => 1,
                ]);
            }
            $next = $sequence->next_sequence;
            $sequence->next_sequence = $next + 1;
            $sequence->save();

            $sequence->load('agency');

            $agencyCode = $sequence->agency->code ?? 'XXX';
            $monthYear = $year.date('m');
            $seqStr = str_pad($next, 4, '0', STR_PAD_LEFT);

            return "{$monthYear}-{$seqStr}-{$agencyCode}";
        });
    }

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
    }

    public function facility(){ return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}
}
