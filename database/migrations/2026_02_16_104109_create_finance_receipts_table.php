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
        Schema::create('finance_receipts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('number')->unique();
            $table->boolean('is_deposit')->default(0);
            $table->boolean('is_cancelled')->default(0);
            $table->bigInteger('op_id')->unsigned()->index();
            $table->foreign('op_id')->references('id')->on('finance_ops')->onDelete('cascade');
            $table->integer('orseries_id')->unsigned()->index();
            $table->foreign('orseries_id')->references('id')->on('finance_orseries')->onDelete('cascade');
            $table->tinyInteger('deposit_id')->unsigned()->index();
            $table->foreign('deposit_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->integer('created_by')->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('agency_id')->unsigned()->index();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->timestamps(); 
            $table->unique(['number','agency_id'], 'agency_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_receipts');
    }
};
