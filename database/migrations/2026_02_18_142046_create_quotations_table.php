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
        Schema::create('quotations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->unique()->nullable();
            $table->decimal('total',12,2)->default(0.00);
            $table->decimal('subtotal',12,2)->default(0.00);
            $table->decimal('discount',12,2)->default(0.00);
            $table->longText('terms')->nullable();
            $table->tinyInteger('discount_id')->unsigned()->index();
            $table->foreign('discount_id')->references('id')->on('list_discounts')->onDelete('cascade');
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->unsignedBigInteger('conforme_id');
            $table->foreign('conforme_id')->references('id')->on('customer_conformes')->onDelete('cascade');
            $table->unsignedSmallInteger('release_id'); 
            $table->foreign('release_id')->references('id')->on('list_data')->onDelete('cascade');
            $table->unsignedTinyInteger('purpose_id');
            $table->foreign('purpose_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedTinyInteger('status_id');
            $table->foreign('status_id')->references('id')->on('list_statuses')->onDelete('cascade');
            $table->unsignedTinyInteger('laboratory_id');
            $table->foreign('laboratory_id')->references('id')->on('list_laboratories')->onDelete('cascade');
            $table->unsignedTinyInteger('facility_id');
            $table->foreign('facility_id')->references('id')->on('agency_facilities')->onDelete('cascade');
            $table->unsignedInteger('agency_id');
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->unsignedInteger('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('is_referral')->default(0);
            $table->boolean('is_onsite')->default(0);
            $table->date('due_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
