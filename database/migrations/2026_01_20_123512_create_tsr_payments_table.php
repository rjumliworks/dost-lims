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
        Schema::create('tsr_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('total',12,2)->default(0.00);
            $table->decimal('subtotal',12,2)->default(0.00);
            $table->decimal('discount',12,2)->default(0.00);
            $table->string('or_number')->nullable();
            $table->boolean('is_paid')->default(0);
            $table->boolean('is_free')->default(0);
            $table->boolean('is_child')->default(0);
            $table->boolean('has_deduction')->default(0);
            $table->unsignedTinyInteger('payment_id')->nullable();
            $table->foreign('payment_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedTinyInteger('collection_id')->nullable();
            $table->foreign('collection_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedTinyInteger('discount_id');
            $table->foreign('discount_id')->references('id')->on('list_discounts')->onDelete('cascade');
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->unsignedBigInteger('tsr_id');
            $table->foreign('tsr_id')->references('id')->on('tsrs')->onDelete('cascade');
            $table->datetime('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_payments');
    }
};
