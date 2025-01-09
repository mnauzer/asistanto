<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('alias');
            $table->string('meno');
            $table->string('priezvisko');
            $table->string('titul')->nullable();
            $table->string('zaradenie');
            $table->boolean('aktivny');
            $table->boolean('sofer')->default('0');
            $table->string('poznamka')->nullable();
            $table->string('avatar')->default('/images/avataaar3.svg');
            $table->bigInteger('user_id')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('employees');
    }
}
