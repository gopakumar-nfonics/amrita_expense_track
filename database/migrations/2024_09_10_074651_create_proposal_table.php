<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal', function (Blueprint $table) {
            $table->id();
            $table->string('proposal_id')->unique(); // Unique proposal_id column
            $table->string('proposal_title'); // Proposal title column
            $table->text('proposal_description'); // Proposal description column
            $table->decimal('proposal_cost', 15, 2); // Proposal cost column (with precision and scale)
            $table->decimal('proposal_gst', 5, 2); // Proposal GST column (with precision and scale)
            $table->decimal('proposal_total_cost', 15, 2); // Proposal total cost column (with precision and scale)
            $table->tinyInteger('proposal_status')->default(0); // Proposal status column with default value
            $table->unsignedBigInteger('vendor_id'); // Vendor ID column
            $table->softDeletes(); // Adds a 'deleted_at' column for soft deletes
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendor')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposal', function (Blueprint $table) {
            // Drop foreign key constraint before dropping the column
            $table->dropForeign(['vendor_id']);
        });
        
        Schema::dropIfExists('proposal');
    }
}
