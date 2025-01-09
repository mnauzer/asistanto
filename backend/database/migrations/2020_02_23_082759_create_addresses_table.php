<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('ulica', 50)->nullable()->default(NULL);
            $table->string('psc', 10)->nullable()->default(NULL);
            $table->string('mesto', 50)->nullable()->default(NULL);
            $table->string('mobil', 15)->nullable()->default(NULL);
            $table->string('email', 50)->nullable()->default(NULL);


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
        Schema::dropIfExists('addresses');
    }
}
