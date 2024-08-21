<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_name');
            $table->string('vendor_code')->unique();
            $table->string('email')->unique();
            $table->string('phone', 15);
            $table->bigInteger('company_id')->unsigned();
            $table->foreign('company_id')->references('id')->on('company');
            $table->string('gst')->nullable();
            $table->string('pan')->nullable();
            $table->text('address');
            $table->softDeletes('deleted_at', 0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor');
    }
}
