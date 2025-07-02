<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->unsignedBigInteger('financial_year_id')->nullable()->after('destination_city');
            $table->unsignedBigInteger('category_id')->nullable()->after('financial_year_id');
            $table->unsignedBigInteger('stream_id')->nullable()->after('category_id');

            $table->foreign('financial_year_id')->references('id')->on('financial_year')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('tbl_category')->onDelete('set null');
            $table->foreign('stream_id')->references('id')->on('stream')->onDelete('set null');

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
            $table->dropForeign(['financial_year_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['stream_id']);

            $table->dropColumn(['financial_year_id', 'category_id', 'stream_id']);
        });
    }
}
