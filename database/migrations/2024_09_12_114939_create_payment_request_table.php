<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_request', function (Blueprint $table) {
            $table->id();
            $table->string('payment_request_id')->unique(); // Unique identifier
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade'); // Foreign key to invoices
            $table->foreignId('stream_id')->constrained('stream')->onDelete('cascade'); // Foreign key to streams
            $table->foreignId('category_id')->constrained('tbl_category')->onDelete('cascade'); // Foreign key to categories
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending'); // Payment status
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
        Schema::dropIfExists('payment_request');
    }
}
