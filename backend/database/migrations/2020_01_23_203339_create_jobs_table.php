<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('datum')->nullable()->default(NULL);
            $table->string('alias', 20)->nullable()->default(NULL);
            $table->time('zaciatok')->nullable()->default(NULL);
            $table->time('koniec')->nullable()->default(NULL);
            $table->double('odpracovane', 5, 2)->nullable()->default(NULL);
            $table->double('sadzba', 5, 2)->nullable()->default(NULL);
            $table->text('popis')->nullable()->default(NULL);
            $table->string ('customer_alias', 20)->nullable()->default(NULL);
            $table->bigInteger('employee_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('order_id')->unsigned()->nullable()->default(NULL);
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
        Schema::dropIfExists('jobs');
    }
}
