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
        Schema::create('finance_deposits', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('start',20);
            $table->string('end',20);
            $table->decimal('total',12,2);
            $table->unsignedTinyInteger('deposit_id');
            $table->foreign('deposit_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedInteger('orseries_id');
            $table->foreign('orseries_id')->references('id')->on('finance_orseries')->onDelete('cascade');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_deposits');
    }
};
