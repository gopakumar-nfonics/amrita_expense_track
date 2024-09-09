<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->nullable()->change();

            // Drop existing foreign key if it exists (use the actual constraint name if different)
            $table->dropForeign(['company_id']);

            // Add the foreign key constraint
            $table->foreign('company_id')->references('id')->on('company')->onDelete('set null');
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
            $table->dropForeign(['company_id']);

            // Modify company_id to be not nullable (if it was previously required)
            $table->unsignedBigInteger('company_id')->nullable(false)->change();

            // Recreate the foreign key constraint (if needed)
            // Note: Replace 'company_id' with your actual constraint name if necessary
            $table->foreign('company_id')->references('id')->on('company')->onDelete('restrict');
        });
    }
}
