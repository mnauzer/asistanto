<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkhoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workhours', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('alias');
            $table->date('datum');
            $table->time('zaciatok');
            $table->time('koniec');
            $table->double('odpracovane');
            $table->double('sadzba');
            $table->double('mzda');
            $table->string('poznamka')->nullable()->default(NULL);
            $table->bigInteger('employee_id');
            
            $table->bigInteger('user_id')->unsigned()->nullable()->default(NULL);

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
        Schema::dropIfExists('workhours');
    }
}
