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
        Schema::create('tsr_signatories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedInteger('received_by')->nullable();
            $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('received_date')->nullable();
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('reviewed_date')->nullable();
            $table->unsignedInteger('collected_by')->nullable();
            $table->foreign('collected_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('collected_date')->nullable();
            $table->unsignedBigInteger('tsr_id');
            $table->foreign('tsr_id')->references('id')->on('tsrs')->onDelete('cascade');
            $table->boolean('is_completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_signatories');
    }
};
