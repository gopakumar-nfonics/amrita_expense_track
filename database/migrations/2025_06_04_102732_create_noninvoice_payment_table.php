<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoninvoicePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('noninvoice_payment', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('reference_id')->unique();
            $table->unsignedBigInteger('financial_year_id');
            $table->foreign('financial_year_id')->references('id')->on('financial_year')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('tbl_category')->onDelete('cascade');
            $table->unsignedBigInteger('stream_id');
            $table->foreign('stream_id')->references('id')->on('stream')->onDelete('cascade');
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('completed');
            $table->decimal('amount', 15, 2);
            $table->date('transaction_date')->nullable();
            $table->string('utr_number')->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('noninvoice_payment');
    }
}
