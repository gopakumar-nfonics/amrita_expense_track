<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressFieldsToVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendor', function (Blueprint $table) {
             // Adjust `after` as per your schema
            $table->string('address_2')->nullable()->after('address');
            $table->string('city')->nullable()->after('address_2');
            $table->string('postcode')->nullable()->after('city');
            $table->string('state')->nullable()->after('postcode');
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
            $table->dropColumn('address_2');
            $table->dropColumn('city');
            $table->dropColumn('postcode');
            $table->dropColumn('state');
        });
    }
}
