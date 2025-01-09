<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cislo')->nullable()->default(NULL);

            $table->date('datum')->nullable()->default(NULL);
            $table->string('popis', 50)->nullable()->default(NULL);
            $table->string('text', 50)->nullable()->default(NULL);

            $table->double('sadzba_dph', 2, 2)->nullable()->default(0.00);
            $table->double('suma_zaklad', 10, 2)->nullable()->default(0.00);
            $table->double('suma_dph', 10, 2)->nullable()->default(0.00);
            $table->double('suma_celkom', 10, 2)->nullable()->default(0.00);


            $table->boolean('doklad')->nullable()->default(false);
            $table->boolean('ucto')->nullable()->default(false);

            $table->bigInteger('expense_category_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('account_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('expenseable_id');
            $table->string('expenseable_type');
            $table->bigInteger('relateable_id');
            $table->string('relateable_type');
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
        Schema::dropIfExists('expenses');
    }
}
