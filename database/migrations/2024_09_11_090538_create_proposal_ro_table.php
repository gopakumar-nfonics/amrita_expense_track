<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalRoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposal_ro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id'); // Assuming proposal_id is a foreign key
            $table->string('proposal_ro'); // Define the column type as needed

            $table->foreign('proposal_id')->references('id')->on('proposal')->onDelete('cascade'); // Assuming 'proposals' table exists and has 'id' column
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
        Schema::dropIfExists('proposal_ro');
    }
}
