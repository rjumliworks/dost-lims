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
        Schema::create('tsr_services', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->decimal('fee',12,2);
            $table->decimal('total',12,2);
            $table->integer('quantity')->default(1);
            $table->unsignedInteger('service_id');
            $table->foreign('service_id')->references('id')->on('testservice_addons')->onDelete('cascade');
            $table->unsignedInteger('typeable_id');
            $table->string('typeable_type');
            $table->boolean('is_additional')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_services');
    }
};
