<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelExpenseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_expense_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travel_expense_id');
            $table->string('head');
            $table->string('expenditure')->nullable();
            $table->decimal('amount', 10, 2);
            $table->timestamps();

            $table->foreign('travel_expense_id')->references('id')->on('tbl_travel_expenses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('travel_expense_details');
    }
}
