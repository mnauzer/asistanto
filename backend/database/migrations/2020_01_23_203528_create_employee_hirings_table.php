<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeHiringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_hirings', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('alias')->nullable()->default(NULL);
            $table->date('platnost')->nullable()->default(NULL);
            $table->bigInteger('rel_id')->unsigned()->nullable()->default(NULL);
            $table->string('poznamka')->nullable()->default(NULL);
            $table->bigInteger('employee_id')->unsigned()->nullable()->default(NULL);
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
        Schema::dropIfExists('employee_hirings');
    }
}
