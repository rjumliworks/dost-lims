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
        // A plain (non-unique) index on kradworkz already exists from the
        // original ->unique()->index() chain, so only the unique constraint
        // needs to be dropped here.
        Schema::table('customer_contacts', function (Blueprint $table) {
            $table->dropUnique(['kradworkz']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_contacts', function (Blueprint $table) {
            $table->unique('kradworkz');
        });
    }
};
