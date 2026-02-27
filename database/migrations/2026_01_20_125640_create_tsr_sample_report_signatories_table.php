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
        Schema::create('tsr_sample_report_signatories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('analyzed_timestamp')->nullable();
            $table->unsignedInteger('analized_by');
            $table->foreign('analized_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('analyzed_date')->nullable();
            $table->string('certified_timestamp')->nullable();
            $table->unsignedInteger('certified_by');
            $table->foreign('certified_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('certified_date')->nullable();
            $table->string('approved_timestamp')->nullable();
            $table->unsignedInteger('approved_by');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('approved_date')->nullable();
            $table->unsignedBigInteger('report_id')->unique();
            $table->foreign('report_id')->references('id')->on('tsr_sample_reports')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_sample_report_signatories');
    }
};
