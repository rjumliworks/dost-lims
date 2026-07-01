<?php

namespace App\Services\Insights\Customer;

use Carbon\Carbon;
use App\Models\Tsr;
class RequestingClass
{
   public function data($request)
   {
      $year = $request->year;

      $customers = Tsr::with([
               'laboratory:id,name',
               'customer'
         ])
         ->where('status_id', '!=', 5)
         ->whereYear('created_at', $year)
         ->orderBy('laboratory_id')
         ->orderBy('customer_id')
         ->orderBy('created_at')
         ->get()
         ->groupBy(function ($item) {
               return $item->laboratory_id . '-' . $item->customer_id;
         });

      $result = [];

      foreach ($customers as $records) {

         $records = $records->sortBy('created_at')->values();

         $first = $records->first();
         $labId = $first->laboratory_id;

         if (!isset($result[$labId])) {

               $result[$labId] = [
                  'laboratory_id' => $labId,
                  'laboratory'    => $first->laboratory->name,

                  'monthly'     => 0,
                  'quarterly'   => 0,
                  'semiannual'  => 0,
                  'yearly'      => 0,

                  'customers' => [
                     'monthly'    => [],
                     'quarterly'  => [],
                     'semiannual' => [],
                     'yearly'     => [],
                  ],
               ];
         }

         // Unique months with requests
         $months = $records->pluck('created_at')
               ->map(function ($date) {
                  return Carbon::parse($date)->month;
               })
               ->unique()
               ->sort()
               ->values();

         $customer = [
               'customer_id' => $first->customer_id,
               'customer'    => $first->customer->fullname, // change if needed
               'months'      => $months->implode(', ')
         ];

         /*
         |--------------------------------------------------------------------------
         | Monthly
         | Requests in ALL 12 months
         |--------------------------------------------------------------------------
         */
         $isMonthly = $months->count() == 12;

         /*
         |--------------------------------------------------------------------------
         | Quarterly
         |--------------------------------------------------------------------------
         */
         $isQuarterly =
               $months->contains(fn($m) => $m >= 1 && $m <= 3) &&
               $months->contains(fn($m) => $m >= 4 && $m <= 6) &&
               $months->contains(fn($m) => $m >= 7 && $m <= 9) &&
               $months->contains(fn($m) => $m >= 10 && $m <= 12);

         /*
         |--------------------------------------------------------------------------
         | Semiannual
         |--------------------------------------------------------------------------
         */
         $isSemiAnnual =
               $months->contains(fn($m) => $m >= 1 && $m <= 6) &&
               $months->contains(fn($m) => $m >= 7 && $m <= 12);

         /*
         |--------------------------------------------------------------------------
         | Yearly
         | Only ONE month with request(s)
         |--------------------------------------------------------------------------
         */
         $isYearly = $months->count() == 1;

         /*
         |--------------------------------------------------------------------------
         | Classification
         |--------------------------------------------------------------------------
         */
         if ($isMonthly) {

               $result[$labId]['monthly']++;
               $result[$labId]['customers']['monthly'][] = $customer;

         } elseif ($isQuarterly) {

               $result[$labId]['quarterly']++;
               $result[$labId]['customers']['quarterly'][] = $customer;

         } elseif ($isSemiAnnual) {

               $result[$labId]['semiannual']++;
               $result[$labId]['customers']['semiannual'][] = $customer;

         } elseif ($isYearly) {

               $result[$labId]['yearly']++;
               $result[$labId]['customers']['yearly'][] = $customer;

         }

         // Customers that don't match any category are intentionally excluded.
      }

      return array_values($result);
   }
}
