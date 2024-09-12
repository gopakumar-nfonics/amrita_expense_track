<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStateForeignKeyToVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->unsignedBigInteger('state')->change(); // Ensure this column is of the correct type
            $table->foreign('state')->references('id')->on('states')->onDelete('set null'); // or use `onDelete('cascade')` if you want to delete vendors when a state is deleted
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->dropForeign(['state']);
            $table->unsignedBigInteger('state')->change();
        });
    }
}
