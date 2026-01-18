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
        Schema::create('testservices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->boolean('is_fixed')->default(1);
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('testname_id');
            $table->foreign('testname_id')->references('id')->on('testservice_names')->onDelete('cascade');
            $table->unsignedInteger('method_id');
            $table->foreign('method_id')->references('id')->on('testservice_methods')->onDelete('cascade');
            $table->unsignedTinyInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->unsignedTinyInteger('laboratory_id');
            $table->foreign('laboratory_id')->references('id')->on('list_laboratories')->onDelete('cascade');
            $table->unsignedInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['testname_id', 'method_id', 'agency_id']);    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testservices');
    }
};
