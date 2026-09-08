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
        Schema::table('packages', function (Blueprint $table) {
            $table->dropUnique(['name','agency_id','laboratory_id','sampletype_id']);
            $table->dropForeign(['sampletype_id']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedInteger('sampletype_id')->nullable()->change();
            $table->foreign('sampletype_id')->references('id')->on('sample_types')->onDelete('cascade');
            $table->unique(['name','agency_id','laboratory_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropUnique(['name','agency_id','laboratory_id']);
            $table->dropForeign(['sampletype_id']);
        });

        Schema::table('packages', function (Blueprint $table) {
            $table->unsignedInteger('sampletype_id')->nullable(false)->change();
            $table->foreign('sampletype_id')->references('id')->on('sample_types')->onDelete('cascade');
            $table->unique(['name','agency_id','laboratory_id','sampletype_id']);
        });
    }
};
