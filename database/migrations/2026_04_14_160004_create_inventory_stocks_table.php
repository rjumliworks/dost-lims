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
        Schema::create('inventory_stocks', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->string('brand')->nullable();
            $table->integer('quantity');
            $table->integer('onhand');
            $table->string('number')->nullable();
            $table->string('cas_number')->nullable();
            $table->decimal('price',12,2)->default(0.00);
            $table->integer('unit');
            $table->boolean('notify')->default(0);
            $table->unsignedTinyInteger('unit_id');
            $table->foreign('unit_id')->references('id')->on('list_dropdowns')->onDelete('cascade');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')->references('id')->on('inventory_items')->onDelete('cascade');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->date('bought_at')->nullable();
            $table->date('expired_at')->nullable();
            $table->date('notify_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};
