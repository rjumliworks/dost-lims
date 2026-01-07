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
        Schema::create('agency_discounts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->unsignedTinyInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('list_discounts')->onDelete('cascade');
            $table->unsignedInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->boolean('is_occasional');
            $table->boolean('is_active');
            $table->timestamps();
            $table->unique(['discount_id','agency_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agency_discounts');
    }
};
