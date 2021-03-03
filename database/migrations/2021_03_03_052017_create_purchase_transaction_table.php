<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_transaction', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("customer_id");
            $table->decimal("total_spent",$precision = 10, $scale = 2);
            $table->decimal("total_saving",$precision = 10, $scale = 2);
            $table->datetime("transaction_at");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_transaction');
    }
}
