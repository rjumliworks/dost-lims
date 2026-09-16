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
            $table->json('printing')->nullable()->after('functionalities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agency_configurations', function (Blueprint $table) {
            $table->dropColumn('printing');
        });
    }
};
