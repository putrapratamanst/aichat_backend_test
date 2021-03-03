<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoucherTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("code")->unique();
            $table->integer("customer_id")->nullable();
            $table->string("is_locked");
            $table->dateTime("submission_time")->nullable();
            $table->dateTime("lockdown_time")->nullable();
            $table->text("exception")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher');
    }
}
