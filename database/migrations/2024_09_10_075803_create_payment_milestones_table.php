<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id'); // Foreign key for proposal
            $table->string('milestone_title'); // Title of the milestone
            $table->date('milestone_date'); // Date of the milestone
            $table->decimal('milestone_amount', 15, 2); // Amount for the milestone
            $table->decimal('milestone_gst', 5, 2); // GST for the milestone
            $table->decimal('milestone_total_amount', 15, 2); // Total amount including GST
            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_milestones', function (Blueprint $table) {
            // Drop foreign key constraint before dropping the column
            $table->dropForeign(['proposal_id']);
        });

        Schema::dropIfExists('payment_milestones');
    }
}
