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
        Schema::create('testservice_lists', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('old_id');
            $table->unsignedInteger('testservice_id');
            $table->foreign('testservice_id')->references('id')->on('testservices')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['old_id', 'testservice_id']);  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testservice_lists');
    }
};
