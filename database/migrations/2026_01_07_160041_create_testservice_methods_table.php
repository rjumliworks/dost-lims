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
        Schema::create('testservice_methods', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->decimal('fee',12,2);
            $table->bigInteger('method_id')->unsigned()->index();
            $table->foreign('method_id')->references('id')->on('testservice_names')->onDelete('cascade');
            $table->bigInteger('reference_id')->unsigned()->index();
            $table->foreign('reference_id')->references('id')->on('testservice_names')->onDelete('cascade');
            $table->tinyInteger('laboratory_id')->unsigned()->index();
            $table->foreign('laboratory_id')->references('id')->on('list_laboratories')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->unique(['name', 'type_id', 'agency_id']);    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testservice_methods');
    }
};
