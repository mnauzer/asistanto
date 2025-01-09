<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('cislo', 20)->nullable()->default(NULL);
            $table->date('datum')->nullable()->default(NULL);
            $table->bigInteger('customer_id')->unsigned()->nullable()->default(NULL);
            $table->string('alias', 20)->nullable()->default(NULL);
            $table->string('nazov', 50)->nullable()->default(NULL);
            $table->string('popis', 255)->nullable()->default(NULL);
            $table->bigInteger('type_id')->unsigned()->nullable()->default(NULL);
            $table->bigInteger('status_id')->unsigned()->nullable()->default(NULL);
            
            $table->bigInteger('destination_id')->unsigned()->nullable()->default(NULL);
            $table->string('miesto', 50)->nullable()->default(NULL);
            $table->double('vzdialenost', 6, 2)->nullable()->default(0.00);
            $table->string('uctovanie_typ', 50)->nullable()->default(NULL);
            $table->string('uctovanie_dopravy', 50)->nullable()->default(NULL);
            $table->bigInteger('offer_id')->unsigned()->nullable()->default(NULL);

            $table->double('sadzba_dph', 2, 2)->nullable()->default(0.00);
            $table->double('suma_zaklad', 12, 2)->nullable()->default(0.00);
            $table->double('suma_dph', 12, 2)->nullable()->default(0.00);
            $table->double('suma_celkom', 12, 2)->nullable()->default(0.00);

            $table->date('vyuctovanie_datum')->nullable()->default(NULL);
            $table->bigInteger('vyuctovanie_id')->unsigned()->nullable()->default(NULL);
            $table->double('vyuctovanie_sadzba_dph', 2, 2)->nullable()->default(0.00);
            $table->double('vyuctovanie_suma_zaklad', 12, 2)->nullable()->default(0.00);
            $table->double('vyuctovanie_suma_dph', 12, 2)->nullable()->default(0.00);
            $table->double('vyuctovanie_suma_celkom', 12, 2)->nullable()->default(0.00);
            
            $table->date('zacatie')->nullable()->default(NULL);
            $table->date('ukoncenie')->nullable()->default(NULL);
            $table->string('poznamka', 255)->nullable()->default(NULL);
            $table->string('short', 50)->nullable()->default(NULL);

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
        Schema::dropIfExists('orders');
    }
}
