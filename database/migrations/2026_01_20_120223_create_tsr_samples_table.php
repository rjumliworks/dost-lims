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
        Schema::create('tsr_samples', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->longText('customer_description');
            $table->longText('description')->nullable();
            $table->boolean('is_completed')->default(0);
            $table->boolean('is_disposed')->default(0);
            $table->unsignedInteger('samplename_id')->nullable();
            $table->foreign('samplename_id')->references('id')->on('sample_names')->onDelete('cascade');
            $table->unsignedInteger('sampletype_id');
            $table->foreign('sampletype_id')->references('id')->on('sample_types')->onDelete('cascade');
            $table->unsignedInteger('category_id');
            $table->foreign('category_id')->references('id')->on('sample_categories')->onDelete('cascade');
            $table->unsignedBigInteger('tsr_id');
            $table->foreign('tsr_id')->references('id')->on('tsrs')->onDelete('cascade');
            $table->date('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tsr_samples');
    }
};
