<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_works', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->date('datum')->nullable();
            $table->double('trvanie', 5, 2)->nullable()->default(NULL);
            $table->text('popis')->nullable()->default(NULL);

            $table->bigInteger('employee_id')->unsigned()->nullable()->default(NULL);
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
        Schema::dropIfExists('extra_works');
    }
}
