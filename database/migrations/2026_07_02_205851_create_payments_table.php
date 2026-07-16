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
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('method')->nullable();
            $table->string('uuid')->unique();
            $table->string('refno')->unique();
            $table->string('txnid')->unique();
            $table->decimal('subtotal',12,2)->default(0.00);
            $table->decimal('fee',12,2)->default(0.00);
            $table->decimal('total',12,2)->default(0.00);
            $table->decimal('amount',12,2)->default(0.00);
            $table->string('status')->default('pending');
            $table->longText('payload')->nullable();
            $table->unsignedBigInteger('tsr_id')->unique();
            $table->foreign('tsr_id')->references('id')->on('tsrs')->onDelete('cascade');
            $table->datetime('paid_at')->nullable();
            $table->datetime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
