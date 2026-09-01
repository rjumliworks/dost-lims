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
       

        Schema::table('finance_deposits', function (Blueprint $table) {
            $table->unsignedSmallInteger('account_id')->nullable()->after('date');
            $table->foreign('account_id')->references('id')->on('list_accounts')->onDelete('cascade');
            $table->unsignedInteger('funding_id')->nullable()->after('account_id');
            $table->foreign('funding_id')->references('id')->on('agency_funds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finance_deposits', function (Blueprint $table) {
            $table->dropForeign(['account_id']);
            $table->dropForeign(['funding_id']);
            $table->dropColumn(['account_id', 'funding_id']);
        });

        Schema::table('finance_deposits', function (Blueprint $table) {
            $table->string('btr_code')->nullable()->after('date');
            $table->string('funding_source')->nullable()->after('btr_code');
            $table->string('fund_code')->nullable()->after('funding_source');
            $table->string('agency_credited')->default('DOST-IX')->after('fund_code');
            $table->string('agency_code')->default('D-3768')->after('agency_credited');
        });
    }
};
