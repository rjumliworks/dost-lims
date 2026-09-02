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
        Schema::table('agency_configurations', function (Blueprint $table) {
            $table->json('functionalities')->nullable()->after('form');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_configurations', function (Blueprint $table) {
            $table->dropColumn('functionalities');
        });
    }
};
