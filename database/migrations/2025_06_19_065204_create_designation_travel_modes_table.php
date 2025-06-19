<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesignationTravelModesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('designation_travel_modes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('travel_mode_id');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->foreign('designation_id')->references('id')->on('designation')->onDelete('cascade');
            $table->foreign('travel_mode_id')->references('id')->on('travel_mode')->onDelete('cascade');

            $table->unique(['designation_id', 'travel_mode_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('designation_travel_modes');
    }
}
