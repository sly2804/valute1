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
            $table->string('id', 10)->unique();
            $table->string('name', 100);
            $table->string('english_name', 100);
            $table->string('alphabetic_code', 3);
            $table->integer('digit_code');
            $table->decimal('rate', 12, 9);
            $table->timestamps();
            $table->primary('id');
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
