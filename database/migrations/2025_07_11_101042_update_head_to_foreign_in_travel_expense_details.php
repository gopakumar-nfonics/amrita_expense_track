<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateHeadToForeignInTravelExpenseDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('travel_expense_details', function (Blueprint $table) {
            $table->dropColumn('head');
            $table->unsignedBigInteger('travel_head')->after('travel_expense_id');

            // Add foreign key constraint
            $table->foreign('travel_head')->references('id')->on('tbl_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('travel_expense_details', function (Blueprint $table) {
            $table->dropForeign(['travel_head']);
            $table->dropColumn('travel_head');
    
            // Restore string column
            $table->string('head')->after('travel_expense_id');
        });
    }
}
