<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatusChangeTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->enum('status', [
                'advance_requested',
                'advance_received',
                'expense_submitted',
                'expense_settled'
            ])->default('advance_requested')->after('destination_city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    
        // Restore the original enum (assuming it included 'pending' as default)
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'advance_requested',
                'advance_received',
                'expense_submitted',
                'expense_settled'
            ])->default('pending')->after('destination_city');
        });
    }
}
