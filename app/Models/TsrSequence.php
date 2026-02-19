<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TsrSequence extends Model
{
    protected $fillable = ['next_sequence', 'year', 'facility_id', 'agency_id', 'laboratory_id','is_tsr'];

    public static function getNextCode($laboratoryId,$typeId)
    {
        return \DB::transaction(function () use ($laboratoryId,$typeId) {
            $user = Auth::user();
            $agencyId = $user->profile?->agency_id;
            $facilityId = $user->profile?->facility_id;
            $year = date('Y');
            
            $sequence = TsrSequence::where([
                'agency_id' => $agencyId,
                'facility_id' => $facilityId,
                'laboratory_id' => $laboratoryId,
                'year' => $year,
                'type_id' => $typeId
            ])->lockForUpdate()->first();

            if (!$sequence) {
                $sequence = TsrSequence::create([
                    'agency_id' => $agencyId,
                    'facility_id' => $facilityId,
                    'laboratory_id' => $laboratoryId,
                    'year' => $year,
                    'type_id' => $typeId,
                    'next_sequence' => 1,
                ]);
            }
            $next = $sequence->next_sequence;
            $sequence->next_sequence = $next + 1;
            $sequence->save();

            $sequence->load('agency', 'laboratory');

            $agencyCode = $sequence->agency->code ?? 'XXX';
            $labCode = $sequence->laboratory->short ?? 'LAB';
            $monthYear = date('m') . $year;

            switch($typeId){
                case 9:
                    $seqStr = str_pad($next, 4, '0', STR_PAD_LEFT);
                    return "{$agencyCode}-{$monthYear}-{$labCode}-{$seqStr}";
                break;
                case 10:
                    $seqStr = str_pad($next, 5, '0', STR_PAD_LEFT);
                    return "{$agencyCode}-{$labCode}-{$seqStr}";
                break;
                case 11:
                    $monthDateYear = date('m').date('d'). $year;
                    $seqStr = str_pad($next, 4, '0', STR_PAD_LEFT);
                    return "{$agencyCode}-{$monthDateYear}-{$labCode}-{$seqStr}";
                break;
                case 12:
                    $seqStr = str_pad($next, 4, '0', STR_PAD_LEFT);
                    return "{$agencyCode}-QUO-{$monthYear}-{$labCode}-{$seqStr}";
                break;
            }
        });
    }

    public static function getQuoCode($typeId)
    {
        return \DB::transaction(function () use ($typeId) {
            $user = Auth::user();
            $agencyId = $user->profile?->agency_id;
            $facilityId = $user->profile?->facility_id;
            $year = date('Y');
            
            $sequence = TsrSequence::where([
                'agency_id' => $agencyId,
                'facility_id' => $facilityId,
                'year' => $year,
                'type_id' => $typeId
            ])->lockForUpdate()->first();

            if (!$sequence) {
                $sequence = TsrSequence::create([
                    'agency_id' => $agencyId,
                    'facility_id' => $facilityId,
                    'laboratory_id' => 1,
                    'year' => $year,
                    'type_id' => $typeId,
                    'next_sequence' => 1,
                ]);
            }
            $next = $sequence->next_sequence;
            $sequence->next_sequence = $next + 1;
            $sequence->save();

            $sequence->load('agency');
            $agencyCode = $sequence->agency->code ?? 'XXX';

            $seqStr = str_pad($next, 4, '0', STR_PAD_LEFT);
            return "QUO-{$agencyCode}-{$year}-{$seqStr}";
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('agency', function (Builder $builder) {
            if (! Auth::check()) {
                return;
            }
            $agencyId = Auth::user()->profile?->agency_id;
            $facilityId = Auth::user()->profile?->facility_id;
            
            if (! $agencyId) {
                abort(403, 'User has no agency assigned.');
            }

            $builder->where('agency_id', $agencyId)->where('facility_id', $facilityId);
        });
    }

    public function laboratory(){ return $this->belongsTo('App\Models\ListLaboratory', 'laboratory_id', 'id');}
    public function facility(){ return $this->belongsTo('App\Models\AgencyFacility', 'facility_id', 'id');}
    public function agency(){ return $this->belongsTo('App\Models\Agency', 'agency_id', 'id');}
}
