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
        Schema::create('tsr_sample_amendments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sample_id');
            $table->foreign('sample_id')->references('id')->on('tsr_samples')->onDelete('cascade');
            $table->longText('previous_description')->nullable();
            $table->longText('proposed_description');
            $table->longText('remarks')->nullable();
            $table->longText('review_remarks')->nullable();
            $table->unsignedInteger('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('reviewed_by')->nullable();
            $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
            $table->datetime('reviewed_at')->nullable();
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->timestamps();
        });

        DB::table('list_statuses')->insert([
            [
                'name' => 'Pending',
                'type' => 'Amendment',
                'color' => 'bg-warning',
                'others' => 'text-warning',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Approved',
                'type' => 'Amendment',
                'color' => 'bg-success',
                'others' => 'text-success',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rejected',
                'type' => 'Amendment',
                'color' => 'bg-danger',
                'others' => 'text-danger',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('list_statuses')->where('type', 'Amendment')->delete();

        Schema::dropIfExists('tsr_sample_amendments');
    }
};
