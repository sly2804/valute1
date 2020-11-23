<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valutes', function (Blueprint $table) {
    
    
            $table->bigIncrements('id');
            $table->string('sec_id', 10);
            $table->string('name', 100);
            $table->string('english_name', 100);
            $table->string('alphabetic_code', 3);
            $table->integer('digit_code');
            $table->decimal('rate',8,4);
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
        Schema::dropIfExists('valutes');
    }
}
