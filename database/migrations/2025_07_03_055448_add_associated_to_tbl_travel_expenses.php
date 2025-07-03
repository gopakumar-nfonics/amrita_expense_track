<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssociatedToTblTravelExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_travel_expenses', function (Blueprint $table) {
            $table->enum('associated', [
                'Vendor Associate',
                'DOA'
            ])->nullable()->after('stream_id');
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
            $table->dropColumn('associated');
        });
    }
}
