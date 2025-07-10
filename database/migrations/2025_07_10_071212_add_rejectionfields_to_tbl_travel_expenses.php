<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectionfieldsToTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->boolean('rejection_status')->default(false)->after('settlement_date');
            $table->text('rejection_reason')->nullable()->after('rejection_status');
            $table->boolean('is_resubmit')->default(false)->after('rejection_reason');
        });

        DB::statement("ALTER TABLE tbl_travel_expenses MODIFY COLUMN status 
            ENUM('advance_requested', 'advance_received', 'expense_submitted', 'expense_settled', 'rejected') 
            DEFAULT 'advance_requested'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->dropColumn('rejection_status');
            $table->dropColumn('rejection_reason');
            $table->dropColumn('is_resubmit');
        });

        DB::statement("ALTER TABLE tbl_travel_expenses MODIFY COLUMN status 
            ENUM('advance_requested', 'advance_received', 'expense_submitted', 'expense_settled') 
            DEFAULT 'advance_requested'");
    }
}
