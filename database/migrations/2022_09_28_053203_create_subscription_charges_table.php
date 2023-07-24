<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_charges', function (Blueprint $table) {
            $table->integer('id');            
            $table->integer('subscription_id');
            $table->foreign('subscription_id')->references('id')->on('subscription_master')->onDelete('cascade');         
            // $table->foreignId('subscription_id')->constrained('subscription_master')->onDelete('cascade');
            $table->float('amount');
            $table->float('tenure');
            $table->dateTime('from_date')->nullable();
            $table->dateTime('to_date')->nullable();
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
        Schema::dropIfExists('subscription_charges');
    }
}
