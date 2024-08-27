<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampusIdToStreamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stream', function (Blueprint $table) {
            $table->unsignedBigInteger('campus_id')->nullable(false)->after('stream_code'); // Adjust the 'after' position as needed

            // Optional: Add a foreign key constraint if the `campus` table exists
            $table->foreign('campus_id')->references('id')->on('campus')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stream', function (Blueprint $table) {
            $table->dropForeign(['campus_id']); // Drop foreign key constraint if it was added
            $table->dropColumn('campus_id');
        });
    }
}
