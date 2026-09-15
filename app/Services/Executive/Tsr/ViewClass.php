<?php

namespace App\Services\Executive\Tsr;

use App\Models\Tsr;
use App\Http\Resources\Executive\Tsr\ListResource;

class ViewClass
{
    private function applyScope($query, $request)
    {
        $query->when($request->laboratory, function ($query, $laboratory) {
                $query->where('laboratory_id', $laboratory);
            })
            ->when($request->agency, function ($query, $agency) {
                $query->where('agency_id', $agency);
            })
            ->when($request->facility, function ($query, $facility) {
                $query->where('facility_id', $facility);
            });
    }

    public function counts($statuses, $request)
    {
        $year = $request->year ?? date('Y');
        $counts = [];

        foreach ($statuses as $status) {
            $query = Tsr::query();
            $this->applyScope($query, $request);

            if ($status['value'] == '2') {
                $query->where(function ($query) {
                    $query->where('status_id', 2)
                        ->orWhere(function ($query) {
                            $query->whereIn('status_id', [3, 4])
                                ->whereHas('payment', function ($query) {
                                    $query->whereIn('status_id', [18, 45]);
                                });
                        });
                });
            } else {
                $query->where('status_id', $status['value']);
            }

            $counts[] = $query->whereYear('created_at', $year)->count();
        }

        return $counts;
    }

    public function typeCounts($request)
    {
        $year = $request->year ?? date('Y');
        $base = Tsr::query();
        $this->applyScope($base, $request);
        $base->whereYear('created_at', $year);

        return [
            'Local' => (clone $base)->where('is_referral', 0)->count(),
            'Referral' => (clone $base)->where('is_referral', 1)->count(),
        ];
    }

    public function list($request, $statuses)
    {
        $data = ListResource::collection(
            Tsr::query()
                ->select('tsrs.*')
                ->with(['customer' => function ($query) {
                    $query->select('id', 'name_id', 'name', 'is_main')
                        ->with(['customer_name' => function ($query) {
                            $query->select('id', 'name', 'has_branches')->withoutGlobalScope('agency');
                        }]);
                }])
                ->with('laboratory:id,name', 'status:id,name,color,others')
                ->with('payment:tsr_id,id,total,is_paid,is_free,paid_at,status_id', 'payment.status:id,name,color,others')
                ->with('agency:id,name')
                ->with('facility:id,name,region_code', 'facility.region:code,name,region')
                ->when($request->keyword, function ($query, $keyword) {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('tsrs.code', 'LIKE', "%{$keyword}%")
                            ->orWhereHas('customer', function ($q) use ($keyword) {
                                $q->join('customer_names', 'customers.name_id', '=', 'customer_names.id')
                                    ->whereRaw("
                                        CASE
                                            WHEN customers.is_main = 1 THEN customer_names.name
                                            ELSE CONCAT(customer_names.name, ' - ', customers.name)
                                        END LIKE ?
                                    ", ["%{$keyword}%"]);
                            })
                            ->orWhereHas('samples', function ($q) use ($keyword) {
                                $q->where('code', 'LIKE', "%{$keyword}%");
                            });
                    });
                })
                ->when($request->status, function ($query, $status) {
                    if ($status == '2') {
                        $query->where(function ($query) {
                            $query->where('status_id', 2)
                                ->orWhere(function ($query) {
                                    $query->whereIn('status_id', [3, 4])
                                        ->whereHas('payment', function ($query) {
                                            $query->whereIn('status_id', [18, 45]);
                                        });
                                });
                        });
                    } else {
                        $query->where('status_id', $status);
                    }
                })
                ->when($request->subtype, function ($query, $subtype) {
                    $query->where('is_onsite', $subtype == 'On-site' ? 1 : 0);
                })
                ->when($request->datetype && $request->date, function ($query) use ($request) {
                    $query->whereDate($request->datetype, $request->date);
                })
                ->when($request->laboratory, function ($query, $laboratory) {
                    $query->where('laboratory_id', $laboratory);
                })
                ->when($request->agency, function ($query, $agency) {
                    $query->where('tsrs.agency_id', $agency);
                })
                ->when($request->facility, function ($query, $facility) {
                    $query->where('tsrs.facility_id', $facility);
                })
                ->when($request->type, function ($query, $type) {
                    ($type == 'Referral') ? $query->where('is_referral', 1) : $query->where('is_referral', 0);
                })
                ->when($request->year, function ($query, $year) {
                    $query->whereYear('tsrs.created_at', $year);
                })
                ->when($request->sort, function ($query, $sort) use ($request) {
                    if ($request->sortby == 'Region') {
                        $query->join('agency_facilities', 'tsrs.facility_id', '=', 'agency_facilities.id')
                            ->orderBy('agency_facilities.region_code', $sort);
                    } elseif ($request->sortby == 'Agency') {
                        $query->join('agencies', 'tsrs.agency_id', '=', 'agencies.id')
                            ->orderBy('agencies.name', $sort);
                    } elseif ($request->sortby == 'Due Date') {
                        $query->orderBy('tsrs.due_at', $sort);
                    } else {
                        $query->orderBy('tsrs.created_at', $sort);
                    }
                }, function ($query) {
                    $query->orderBy('tsrs.created_at', 'DESC');
                })
                ->orderBy('tsrs.id', 'asc')
                ->paginate($request->count ?? 20)
        )->additional([
            'summary' => $this->counts($statuses, $request),
            'typeCounts' => $this->typeCounts($request),
        ]);

        return $data;
    }
}
