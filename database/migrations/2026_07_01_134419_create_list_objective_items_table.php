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
        Schema::create('list_objective_items', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->tinyIncrements('id');
            $table->string('name');
            $table->unsignedTinyInteger('objective_id');
            $table->foreign('objective_id')->references('id')->on('list_objectives')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_objective_items');
    }
};
