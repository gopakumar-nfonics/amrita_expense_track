<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBudgetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_budget', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('financial_year_id');
            $table->unsignedBigInteger('category_id');
            $table->decimal('amount', 15, 2); // Example: 99999999999.99
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Adds the `deleted_at` column for soft deletes

            // Foreign key constraints
            $table->foreign('financial_year_id')->references('id')->on('financial_year')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('tbl_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_budget', function (Blueprint $table) {
            $table->dropForeign(['financial_year_id']);
            $table->dropForeign(['category_id']);
        });
        Schema::dropIfExists('tbl_budget');
    }
}
