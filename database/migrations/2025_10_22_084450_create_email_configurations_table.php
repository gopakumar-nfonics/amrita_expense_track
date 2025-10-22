<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_configurations', function (Blueprint $table) {
            $table->id();
            $table->string('email_type')->comment('Type of email: budget_report, etc.');
            $table->string('email_address');
            $table->string('recipient_name')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('frequency')->default('weekly')->comment('daily, weekly, monthly');
            $table->json('additional_settings')->nullable()->comment('JSON field for extra settings');
            $table->timestamps();
            
            $table->index(['email_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_configurations');
    }
}
