<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');


            $table->string('employee_id', 20)->nullable()->default(NULL);
            $table->string('typ', 20)->nullable()->default(NULL);
            $table->string('ucel', 100)->nullable()->default(NULL);
            $table->string('nazov', 255)->nullable()->default(NULL);
            $table->double('zostatok', 12, 2)->nullable()->default(0.00);
            $table->boolean('aktivny');
            $table->string('prefix', 10)->nullable()->default(NULL);
            $table->string('icon', 50)->nullable()->default(NULL);
            $table->string('color', 50)->nullable()->default(NULL);
            $table->string('color_text', 50)->nullable()->default(NULL);


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
        Schema::dropIfExists('accounts');
    }
}
