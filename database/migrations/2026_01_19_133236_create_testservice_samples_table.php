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
        Schema::create('testservice_samples', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('sampleable_id');
            $table->string('sampleable_type');
            $table->unsignedInteger('testservice_id');
            $table->foreign('testservice_id')->references('id')->on('testservices')->onDelete('cascade');
            $table->unsignedInteger('added_by');
            $table->foreign('added_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['sampleable_id', 'testservice_id']);      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testservice_samples');
    }
};
