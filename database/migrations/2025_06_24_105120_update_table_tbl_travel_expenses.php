<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->string('title')->after('staff_id');
            $table->unsignedBigInteger('source_city')->after('to_date');
            $table->unsignedBigInteger('destination_city')->after('source_city');

            $table->foreign('source_city')->references('id')->on('city')->onDelete('cascade');
            $table->foreign('destination_city')->references('id')->on('city')->onDelete('cascade');
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
            // Drop foreign keys first
            $table->dropForeign(['source_city']);
            $table->dropForeign(['destination_city']);

            // Drop columns
            $table->dropColumn(['title', 'source_city', 'destination_city']);
        });
    }
}
