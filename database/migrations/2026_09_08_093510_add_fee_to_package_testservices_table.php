<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('package_testservices', function (Blueprint $table) {
            $table->decimal('fee',12,2)->default(0.00)->after('testservice_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('package_testservices', function (Blueprint $table) {
            $table->dropColumn('fee');
        });
    }
};
