<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaingProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaing_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaing_id');
            $table->string('product_id');
            $table->string('price')->nullable();
            $table->timestamps();
            $table->foreign('campaing_id')->references('id')->on('campaings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campaing_product');
    }
}
