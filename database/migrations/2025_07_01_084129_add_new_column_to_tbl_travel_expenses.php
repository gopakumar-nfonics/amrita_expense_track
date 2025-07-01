<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->decimal('advance_amount', 10, 2)->nullable()->after('amount');
            $table->dropColumn('status');
        });

        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->enum('status', [
                'pending',
                'advance_requested',
                'advance_received',
                'expense_submitted',
                'expense_settled'
            ])->default('pending')->after('amount');
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
            $table->dropColumn('advance_amount');
            $table->dropColumn('status');
        });

        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('amount');
        });
    }
}
