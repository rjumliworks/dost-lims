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
        Schema::create('equipment_infos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigincrements('id');
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_no')->nullable();
            $table->longText('others')->nullable();
            $table->decimal('price',12,2)->nullable();
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('equipment_id');
            $table->foreign('equipment_id')->references('id')->on('equipment')->onDelete('cascade');
            $table->date('acquired_at')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_infos');
    }
};
