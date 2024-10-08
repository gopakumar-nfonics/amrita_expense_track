<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDepartmentIdNullableInStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stream', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id')->nullable()->change();
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
            $table->unsignedBigInteger('department_id')->nullable(false)->change();
        });
    }
}
