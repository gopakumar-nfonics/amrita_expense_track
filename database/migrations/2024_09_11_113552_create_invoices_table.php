<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id'); // Foreign key to proposals table
            $table->unsignedBigInteger('milestone_id'); // Foreign key to milestones table
            $table->string('invoice_number')->unique(); // Invoice number, unique
            $table->date('invoice_date'); // Invoice date
            $table->string('invoice_file'); // File path or filename for the invoice
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade');
            $table->foreign('milestone_id')->references('id')->on('payment_milestones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
