<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateIdToCity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('city', function (Blueprint $table) {
            $table->unsignedBigInteger('state_id')->nullable()->after('tier_id');

            $table->foreign('state_id')->references('id')->on('states')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('city', function (Blueprint $table) {
            $table->dropForeign(['state_id']);
            $table->dropColumn('state_id');
        });
    }
}
