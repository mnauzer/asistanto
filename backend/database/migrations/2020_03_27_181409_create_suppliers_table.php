<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            $table->string('alias', 20)->nullable()->default(NULL);
            $table->boolean('fo')->nullable()->default(true);

            $table->string('meno', 50)->nullable()->default(NULL);
            $table->string('priezvisko', 50)->nullable()->default(NULL);
            $table->string('titul', 10)->nullable()->default(NULL);

            $table->string('firma_nazov', 50)->nullable()->default(NULL);

            $table->boolean('aktivny')->nullable()->default(true);
            $table->string('poznamka', 255)->nullable()->default(NULL);
            
            $table->bigInteger('user_id')->unsigned()->nullable()->default(NULL);

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
        Schema::dropIfExists('suppliers');
    }
}
