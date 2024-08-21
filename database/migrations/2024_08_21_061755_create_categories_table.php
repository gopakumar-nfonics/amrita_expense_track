<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_category', function (Blueprint $table) {
            $table->id();
            $table->string('category_name')->unique();
            $table->string('category_code')->unique();
            $table->unsignedBigInteger('parent_category')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();

            // Foreign key constraint referencing the same table for hierarchical categories
            $table->foreign('parent_category')->references('id')->on('tbl_category')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_category');
    }
}
