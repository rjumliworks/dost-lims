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
        Schema::create('quotation_analyses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('fee',12,2);
            $table->unsignedInteger('testservice_id');
            $table->foreign('testservice_id')->references('id')->on('testservices')->onDelete('cascade');
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id')->references('id')->on('quotation_samples')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_analyses');
    }
};
