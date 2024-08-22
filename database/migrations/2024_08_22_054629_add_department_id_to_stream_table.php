<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentIdToStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stream', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->after('stream_code'); // Adding department_id field
            $table->foreign('department_id')->references('id')->on('department')->onDelete('cascade'); // Setting up the foreign key
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stream', function (Blueprint $table) {
            $table->dropForeign(['department_id']); // Dropping the foreign key
            $table->dropColumn('department_id');
        });
    }
}
