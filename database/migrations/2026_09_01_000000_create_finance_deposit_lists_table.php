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
        Schema::create('finance_deposit_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->bigInteger('finance_deposit_id')->unsigned()->index();
            $table->foreign('finance_deposit_id')->references('id')->on('finance_deposits')->onDelete('cascade');
            $table->bigInteger('finance_receipt_id')->unsigned()->index();
            $table->foreign('finance_receipt_id')->references('id')->on('finance_receipts')->onDelete('cascade');
            $table->timestamps();
            $table->unique('finance_receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_deposit_lists');
    }
};
