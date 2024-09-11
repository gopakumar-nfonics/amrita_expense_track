<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorBankAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id'); // Foreign key for Vendor
            $table->string('beneficiary_name'); // Beneficiary Name
            $table->string('account_no'); // Account Number
            $table->string('ifsc_code'); // IFSC Code
            $table->string('bank_name'); // Bank Name
            $table->string('branch_name'); // Branch Name
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
        Schema::dropIfExists('vendor_bank_accounts');
    }
}
