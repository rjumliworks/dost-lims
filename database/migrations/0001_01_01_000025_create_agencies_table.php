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
        Schema::create('agencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code',10)->unique();
            $table->string('name')->unique();
            $table->year('member_since')->nullable();
            $table->string('contact_no')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedTinyInteger('type_id');
            $table->foreign('type_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agencies');
    }
};
