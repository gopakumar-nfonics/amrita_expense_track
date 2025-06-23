<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyAllowanceAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_allowance_accommodations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id');
            $table->unsignedBigInteger('city_tier_id')->nullable();
            $table->decimal('allowance_amount', 10, 2);
            $table->decimal('accommodation_amount', 10, 2);
            $table->timestamps();

            $table->foreign('designation_id')->references('id')->on('designation')->onDelete('cascade');
            $table->foreign('city_tier_id')->references('id')->on('tier')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_allowance_accommodations');
    }
}
