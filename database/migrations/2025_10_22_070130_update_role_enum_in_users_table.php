<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRoleEnumInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
             DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Expense Manager', 'Vendor', 'Reporter') NOT NULL DEFAULT 'Vendor'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Expense Manager', 'Vendor') NOT NULL DEFAULT 'Vendor'");
        });
    }
}
