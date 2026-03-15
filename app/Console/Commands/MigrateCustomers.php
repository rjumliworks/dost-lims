<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\CustomerConforme;
use App\Models\CustomerContact;

class MigrateCustomers extends Command
{
    protected $signature = 'migrate:customers {old_key} {--limit=0}';
    protected $description = 'Migrate customers from old DB including encrypted fields';

    private $oldEncrypters;

    public function handle()
    {
        $oldKey = $this->argument('old_key');
        $limit = (int) $this->option('limit');

        $this->info("Starting customer migration...");

        // 1️⃣ Setup old encrypter
        $this->makeOldEncrypter($oldKey);

        // 2️⃣ Truncate all customer-related tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $tables = [
            'customer_conformes',
            'customer_contacts',
            'customer_addresses',
            'customers',
            'customer_names',
        ];
        foreach ($tables as $table) {
            DB::table($table)->truncate();
            $this->info("Truncated {$table}");
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // 3️⃣ Migrate customer_names (only those with customers with TSRS)
        $oldNames = DB::connection('old_db')
            ->table('customer_names as cn')
            ->join('customers as c', 'c.name_id', '=', 'cn.id')
            ->join('tsrs as t', 't.customer_id', '=', 'c.id')
            ->where('t.agency_id', 14)
            ->select('cn.*')
            ->distinct()
            ->get();

        $nameMapping = [];
        foreach ($oldNames as $oldName) {
            $newNameId = DB::table('customer_names')->insertGetId([
                'name' => $oldName->name,
                'agency_id' => 14,
                'has_branches' => $oldName->has_branches,
                'is_active' => $oldName->is_active,
                'created_at' => $oldName->created_at,
                'updated_at' => $oldName->updated_at,
            ]);
            $nameMapping[$oldName->id] = $newNameId;
        }

        // 4️⃣ Migrate customers with TSRS
        $query = DB::connection('old_db')
            ->table('customers')
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('tsrs')
                    ->whereColumn('tsrs.customer_id', 'customers.id')
                    ->where('tsrs.agency_id', 14)->whereIn('tsrs.status_id', [2,3,4]);
            })
            ->orderBy('id');

        if ($limit > 0) {
            $query->limit($limit);
        }

        $query->chunk(100, function ($oldCustomers) use ($nameMapping) {

            foreach ($oldCustomers as $oldCustomer) {

                DB::transaction(function () use ($oldCustomer, $nameMapping) {

                    // 4a️⃣ Insert customer
                    $newCustomerId = DB::table('customers')->insertGetId([
                        'name_id' => $nameMapping[$oldCustomer->name_id] ?? null,
                        'code' => $oldCustomer->code,
                        'name' => $oldCustomer->name,
                        'industry_id' => $oldCustomer->industry_id,
                        'classification_id' => $oldCustomer->classification_id,
                        'sex_id' => $oldCustomer->sex_id,
                        'led_id' => $oldCustomer->female_id,
                        'type_id' => $oldCustomer->type_id,
                        'is_active' => $oldCustomer->is_active,
                        'is_internal' => $oldCustomer->is_internal,
                        'is_main' => $oldCustomer->is_main,
                        'user_id' => User::where('old_id', $oldCustomer->user_id)->value('id') ?? 1,
                        'is_new' => $oldCustomer->is_new,
                        'agency_id' => $oldCustomer->agency_id,
                        'created_at' => $oldCustomer->created_at,
                        'updated_at' => $oldCustomer->updated_at,
                        'old_id' => $oldCustomer->id
                    ]);

                    // 4b️⃣ Migrate customer_conformes
                    $conformes = DB::connection('old_db')
                        ->table('customer_conformes')
                        ->where('customer_id', $oldCustomer->id)
                        ->get();

                    foreach ($conformes as $c) {
                        $name = $this->safeDecrypt($c->name);
                        $contact = $this->safeDecrypt($c->contact_no);

                        CustomerConforme::create([
                            'customer_id' => $newCustomerId,
                            'name' => $name ?: 'None',
                            'contact_no' => $contact,
                        ]);
                    }

                    // 4c️⃣ Migrate customer_contacts
                    $contacts = DB::connection('old_db')
                        ->table('customer_contacts')
                        ->where('customer_id', $oldCustomer->id)
                        ->get();

                    $existingEmails = [];

                    foreach ($contacts as $c) {
                        $email = $this->safeDecrypt($c->email) ?: 'none@onelab.com';
                        $contact = $this->safeDecrypt($c->contact_no);

                        CustomerContact::create([
                            'customer_id' => $newCustomerId,
                            'email' => $email,
                            'contact_no' => $contact,
                        ]);
                    }

                    // 4d️⃣ Migrate customer_addresses
                    $addr = DB::connection('old_db')
                        ->table('customer_addresses')
                        ->where('customer_id', $oldCustomer->id)
                        ->first();

                    if ($addr) {
                        DB::table('customer_addresses')->insert([
                            'customer_id' => $newCustomerId,
                            'address' => $addr->address ?: '-',
                            'longitude' => $addr->longitude,
                            'latitude' => $addr->latitude,
                            'district_code' => $addr->district_code,
                            'barangay_code' => $addr->barangay_code,
                            'municipality_code' => $addr->municipality_code,
                            'province_code' => $addr->province_code,
                            'region_code' => $addr->region_code,
                            'created_at' => $addr->created_at,
                            'updated_at' => $addr->updated_at,
                        ]);
                    }

                }); // end transaction

                $this->info("Migrated customer ID {$oldCustomer->id}");
            }

        });

        $this->info("Customer migration completed successfully.");
    }

    private function makeOldEncrypter($oldKey)
    {
        $keys = [$oldKey];

        $previous = env('APP_PREVIOUS_KEYS');

        if ($previous) {
            $keys = array_merge($keys, explode(',', $previous));
        }

        foreach ($keys as $key) {

            $key = trim($key);

            if (Str::startsWith($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            $this->oldEncrypters[] = new \Illuminate\Encryption\Encrypter($key, config('app.cipher'));
        }
    }

    private function safeDecrypt($value)
    {
        if (!$value) {
            return null;
        }

        // If value does not look encrypted, return as is
        if (!Str::startsWith($value, ['eyJpdiI', 'base64:'])) {
            return $value;
        }

        try {
            return $this->oldEncrypter->decryptString($value);
        } catch (\Exception $e) {
            $this->warn("Decrypt failed, returning raw value");
            return $value;
        }
    }
}