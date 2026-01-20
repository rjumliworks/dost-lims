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
        Schema::create('tsr_analyses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('fee',12,2);
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->unsignedInteger('testservice_id');
            $table->foreign('testservice_id')->references('id')->on('testservices')->onDelete('cascade');
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id')->references('id')->on('tsr_samples')->onDelete('cascade');
            $table->unsignedInteger('analyst_id')->nullable();
            $table->foreign('analyst_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('start_at')->nullable();
            $table->date('end_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_analyses');
    }
};
