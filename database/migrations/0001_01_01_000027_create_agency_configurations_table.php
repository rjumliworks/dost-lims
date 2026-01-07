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
        Schema::create('agency_configurations', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->json('laboratories');
            $table->json('form');
            $table->json('contact');
            $table->boolean('samplecode_year');
            $table->boolean('show_others');
            $table->boolean('strict_mode');
            $table->unsignedInteger('agency_id')->unique();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_configurations');
    }
};
