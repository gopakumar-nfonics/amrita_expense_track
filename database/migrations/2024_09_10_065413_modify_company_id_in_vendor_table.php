<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyCompanyIdInVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            
            // Modify the column to be nullable and ensure it matches the foreign key definition
            $table->unsignedBigInteger('company_id')->nullable()->change();
            
            // Add the foreign key constraint
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('set null');
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
            
            // Modify the column back to its original state if needed (this example assumes it was not nullable)
            $table->unsignedBigInteger('company_id')->nullable(false)->change();
            
            // Recreate the old foreign key constraint if applicable (assuming the previous behavior)
            $table->foreign('company_id')
                  ->references('id')
                  ->on('company')
                  ->onDelete('restrict'); // Adjust this to match the original constraint if needed
        });
    }
}
