<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Recreates list_statuses for environments where it was manually
     * dropped after its original migration already ran (so `migrate`
     * alone won't recreate it). No-op if the table already exists.
     */
    public function up(): void
    {
        if (Schema::hasTable('list_statuses')) {
            return;
        }

        Schema::create('list_statuses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->tinyIncrements('id');
            $table->string('name',100);
            $table->string('type',20)->defualt('n/a');
            $table->string('color',20)->default('n/a');
            $table->string('others')->default('n/a');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
