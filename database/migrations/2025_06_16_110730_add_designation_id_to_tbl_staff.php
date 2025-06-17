<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDesignationIdToTblStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->unsignedBigInteger('designation_id')->nullable(false)->after('email');
            $table->foreign('designation_id')->references('id')->on('designation')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_staff', function (Blueprint $table) {
            $table->dropForeign(['designation_id']);
            $table->dropColumn('designation_id');
        });
    }
}
