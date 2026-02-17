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
        Schema::create('finance_ops', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->decimal('total',12,2);
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->tinyInteger('collection_id')->unsigned()->nullable();
            $table->foreign('collection_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->tinyInteger('payment_id')->unsigned()->nullable();
            $table->foreign('payment_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedInteger('payorable_id');
            $table->string('payorable_type');
            $table->integer('created_by')->unsigned()->index();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->integer('agency_id')->unsigned()->index();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['code','agency_id'], 'agency_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finance_ops');
    }
};
