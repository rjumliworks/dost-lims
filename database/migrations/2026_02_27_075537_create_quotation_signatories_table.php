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
        Schema::create('quotation_signatories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('hmac')->nullable();
            $table->integer('version')->default(1);
            $table->unsignedInteger('prepared_by')->nullable();
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('prepared_date')->nullable();
            $table->unsignedInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('approved_date')->nullable();
            $table->unsignedInteger('received_by')->nullable();
            $table->foreign('received_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('received_date')->nullable();
            $table->unsignedBigInteger('quotation_id')->unique();
            $table->foreign('quotation_id')->references('id')->on('quotations')->onDelete('cascade');
            $table->boolean('is_completed')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_signatories');
    }
};
