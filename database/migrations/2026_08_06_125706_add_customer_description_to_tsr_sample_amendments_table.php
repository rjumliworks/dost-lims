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
        Schema::table('tsr_sample_amendments', function (Blueprint $table) {
            $table->longText('previous_customer_description')->nullable()->after('previous_description');
            $table->longText('proposed_customer_description')->nullable()->after('proposed_description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tsr_sample_amendments', function (Blueprint $table) {
            $table->dropColumn(['previous_customer_description', 'proposed_customer_description']);
        });
    }
};
