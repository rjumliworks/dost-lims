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
        Schema::create('target_items', function (Blueprint $table) {
            $table->engine = 'InnoDB'; 
            $table->increments('id');
            $table->integer('count')->default(0);
            $table->integer('accom')->default(0);
            $table->boolean('is_set')->default(0);
            $table->boolean('is_amount')->default(0);
            $table->unsignedInteger('target_id');
            $table->foreign('target_id')->references('id')->on('target_breakdowns')->onDelete('cascade');
            $table->unsignedTinyInteger('item_id');
            $table->foreign('item_id')->references('id')->on('list_objective_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_items');
    }
};
