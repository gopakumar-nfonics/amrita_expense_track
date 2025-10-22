<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmailConfigurationsTableRemoveFrequency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->dropColumn(['frequency', 'additional_settings']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('email_configurations', function (Blueprint $table) {
            $table->string('frequency')->default('weekly')->comment('daily, weekly, monthly');
            $table->json('additional_settings')->nullable()->comment('JSON field for extra settings');
        });
    }
}
