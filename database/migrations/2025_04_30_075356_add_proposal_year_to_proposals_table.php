<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProposalYearToProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proposal', function (Blueprint $table) {
            $table->unsignedBigInteger('proposal_year')->nullable()->after('proposal_id'); // or after any relevant column
            $table->foreign('proposal_year')
                  ->references('id')
                  ->on('financial_year')
                  ->onDelete('set null'); 
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
            $table->dropForeign(['proposal_year']);
            $table->dropColumn('proposal_year');
        });
    }
}
