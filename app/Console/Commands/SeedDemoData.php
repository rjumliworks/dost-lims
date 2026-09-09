<?php

namespace App\Console\Commands;

use App\Models\Agency;
use App\Models\ListLaboratory;
use App\Models\ListRole;
use App\Models\Testservice;
use App\Models\TestserviceAddon;
use App\Models\TestserviceMethod;
use App\Models\TestserviceName;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class SeedDemoData extends Command
{
    protected $signature = 'demo:seed
        {--agency= : Agency ID to attach demo users/services to (defaults to the agency of --admin)}
        {--admin=1 : User ID recorded as the creator of seeded records}
        {--password=Demo@12345 : Password assigned to every seeded demo user}
        {--fresh : Delete previously seeded demo users/test services/add-ons before creating new ones}
        {--database= : Run against a non-default DB connection (e.g. mysql_test)}';

    protected $description = 'Seed standard demo users (CRO, lab head, technical manager, analyst per lab, accounting, cashier) plus 3 demo test services per lab (with add-ons for the Metrology lab) for testing/staging deployments';

    private const EMAIL_DOMAIN = 'demo.lims.test';
    private const SEX_ID_MALE = 7; // list_data: type=Sex
    private const TYPE_ID_METHOD = 28; // list_dropdowns
    private const TYPE_ID_REFERENCE = 29; // list_dropdowns
    private const TYPE_ID_TESTNAME = 31; // list_dropdowns

    public function handle()
    {
        if ($this->option('database')) {
            \DB::setDefaultConnection($this->option('database'));
        }

        $adminId = (int) $this->option('admin');
        $admin = User::find($adminId);

        if (! $admin) {
            $this->error("Admin user #{$adminId} not found. Pass --admin=<existing user id>.");
            return 1;
        }

        $agencyId = $this->option('agency') ? (int) $this->option('agency') : $admin->profile?->agency_id;

        if (! $agencyId || ! Agency::whereKey($agencyId)->exists()) {
            $this->error('Could not resolve a valid agency. Pass --agency=<existing agency id>.');
            return 1;
        }

        $roleIds = ListRole::whereIn('name', [
            'Laboratory Head', 'Technical Manager', 'Customer Relation Officer',
            'Laboratory Analyst', 'Accountant', 'Cashier',
        ])->pluck('id', 'name');

        foreach (['Laboratory Head', 'Technical Manager', 'Customer Relation Officer', 'Laboratory Analyst', 'Accountant', 'Cashier'] as $roleName) {
            if (! $roleIds->has($roleName)) {
                $this->error("Required role \"{$roleName}\" not found in list_roles. Run the base seeders first.");
                return 1;
            }
        }

        $labs = ListLaboratory::where('is_active', 1)->get();

        if ($labs->isEmpty()) {
            $this->error('No active laboratories found. Seed list_laboratories first.');
            return 1;
        }

        $password = $this->option('password');

        if ($this->option('fresh')) {
            $this->purgeDemoData($labs, $agencyId);
        }

        $this->info("Seeding demo data for agency #{$agencyId}, added_by user #{$adminId}...");

        $this->seedUser('cro', 'Demo', 'CRO', $roleIds['Customer Relation Officer'], null, $agencyId, $adminId, $password);
        $this->seedUser('accounting', 'Demo', 'Accounting', $roleIds['Accountant'], null, $agencyId, $adminId, $password);
        $this->seedUser('cashier', 'Demo', 'Cashier', $roleIds['Cashier'], null, $agencyId, $adminId, $password);

        foreach ($labs as $lab) {
            $short = Str::lower($lab->short);

            $this->seedUser("labhead_{$short}", $lab->name, 'Lab Head', $roleIds['Laboratory Head'], $lab->id, $agencyId, $adminId, $password);
            $this->seedUser("techmgr_{$short}", $lab->name, 'Tech Manager', $roleIds['Technical Manager'], $lab->id, $agencyId, $adminId, $password);
            $this->seedUser("analyst_{$short}", $lab->name, 'Analyst', $roleIds['Laboratory Analyst'], $lab->id, $agencyId, $adminId, $password);

            $this->seedTestServices($lab, $agencyId, $adminId);

            if (Str::contains(Str::upper($lab->short ?? ''), 'MET') || Str::contains(Str::lower($lab->name), 'metro')) {
                $this->seedAddons($lab, $agencyId, $adminId);
            }
        }

        $this->newLine();
        $this->info("Done. All demo users share the password: {$password}");
        $this->line('(On a local environment, "000000" also works for any account regardless of its real password.)');

        return 0;
    }

    private function seedUser(string $username, string $firstname, string $lastname, int $roleId, ?int $laboratoryId, int $agencyId, int $adminId, string $password): void
    {
        $user = User::firstOrCreate(
            ['username' => $username],
            [
                'email' => "{$username}@" . self::EMAIL_DOMAIN,
                'password' => $password,
                'is_active' => 1,
                'must_change' => 0,
                'email_verified_at' => now(),
            ]
        );

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'firstname' => $firstname,
                'lastname' => $lastname,
                'middlename' => 'Demo',
                'mobile' => '09' . str_pad((string) $user->id, 9, '0', STR_PAD_LEFT),
                'sex_id' => self::SEX_ID_MALE,
                'agency_id' => $agencyId,
            ]
        );

        $user->myroles()->updateOrCreate(
            ['role_id' => $roleId, 'laboratory_id' => $laboratoryId],
            ['added_by' => $adminId]
        );

        $this->line(" - user: {$username} ({$lastname})");
    }

    private function seedTestServices(ListLaboratory $lab, int $agencyId, int $adminId): void
    {
        for ($i = 1; $i <= 3; $i++) {
            $testName = TestserviceName::firstOrCreate([
                'name' => "Demo Test {$i} ({$lab->short})",
                'short' => "DT{$i}{$lab->short}",
                'type_id' => self::TYPE_ID_TESTNAME,
                'laboratory_id' => $lab->id,
                'agency_id' => $agencyId,
            ], ['added_by' => $adminId]);

            $method = TestserviceName::firstOrCreate([
                'name' => "Demo Method {$i} ({$lab->short})",
                'short' => "DM{$i}{$lab->short}",
                'type_id' => self::TYPE_ID_METHOD,
                'laboratory_id' => $lab->id,
                'agency_id' => $agencyId,
            ], ['added_by' => $adminId]);

            $reference = TestserviceName::firstOrCreate([
                'name' => "Demo Reference {$i} ({$lab->short})",
                'short' => "DR{$i}{$lab->short}",
                'type_id' => self::TYPE_ID_REFERENCE,
                'laboratory_id' => $lab->id,
                'agency_id' => $agencyId,
            ], ['added_by' => $adminId]);

            $testMethod = TestserviceMethod::firstOrCreate([
                'method_id' => $method->id,
                'reference_id' => $reference->id,
                'laboratory_id' => $lab->id,
                'agency_id' => $agencyId,
            ], [
                'fee' => 500 * $i,
                'added_by' => $adminId,
            ]);

            $exists = Testservice::where([
                'testname_id' => $testName->id,
                'method_id' => $testMethod->id,
                'agency_id' => $agencyId,
                'is_new' => 1,
            ])->exists();

            if (! $exists) {
                $testservice = new Testservice();
                $testservice->forceFill([
                    'laboratory_id' => $lab->id,
                    'testname_id' => $testName->id,
                    'method_id' => $testMethod->id,
                    'is_active' => 1,
                    'is_new' => 1,
                    'agency_id' => $agencyId,
                    'added_by' => $adminId,
                ]);
                $testservice->save();
            }
        }

        $this->line(" - 3 test services seeded for {$lab->name}");
    }

    private function seedAddons(ListLaboratory $lab, int $agencyId, int $adminId): void
    {
        $addons = [
            ['name' => 'On-site Calibration Fee', 'fee' => 1500, 'is_onsite' => 1],
            ['name' => 'Rush Fee', 'fee' => 800, 'is_additional' => 1],
        ];

        foreach ($addons as $addon) {
            $exists = TestserviceAddon::where([
                'name' => $addon['name'],
                'fee' => $addon['fee'],
                'typeable_id' => $lab->id,
                'typeable_type' => ListLaboratory::class,
                'agency_id' => $agencyId,
            ])->exists();

            if ($exists) {
                continue;
            }

            $model = new TestserviceAddon();
            $model->forceFill([
                'name' => $addon['name'],
                'fee' => $addon['fee'],
                'description' => "Demo add-on for {$lab->name}",
                'is_additional' => $addon['is_additional'] ?? 0,
                'is_onsite' => $addon['is_onsite'] ?? 0,
                'is_child' => 0,
                'is_active' => 1,
                'typeable_id' => $lab->id,
                'typeable_type' => ListLaboratory::class,
                'agency_id' => $agencyId,
                'added_by' => $adminId,
            ]);
            $model->save();
        }

        $this->line(" - add-ons seeded for {$lab->name}");
    }

    private function purgeDemoData($labs, int $agencyId): void
    {
        $this->warn('Purging previously seeded demo data...');

        $usernames = ['cro', 'accounting', 'cashier'];

        foreach ($labs as $lab) {
            $short = Str::lower($lab->short);
            $usernames[] = "labhead_{$short}";
            $usernames[] = "techmgr_{$short}";
            $usernames[] = "analyst_{$short}";
        }

        User::whereIn('username', $usernames)->delete();

        TestserviceAddon::where('agency_id', $agencyId)
            ->where('description', 'like', 'Demo add-on for%')
            ->delete();

        TestserviceName::where('agency_id', $agencyId)
            ->where('name', 'like', 'Demo %')
            ->delete();
    }
}
