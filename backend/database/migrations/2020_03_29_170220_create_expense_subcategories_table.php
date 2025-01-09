<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpenseSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_subcategories', function (Blueprint $table) {
            $table->id();
                $table->string('nazov', 50)->nullable()->default(NULL);
            $table->string('text', 50)->nullable()->default(NULL);
            $table->string('model', 50)->nullable()->default(NULL);
               $table->bigInteger('category_id');
            $table->string('icon', 50)->nullable()->default(NULL);
            $table->string('color', 50)->nullable()->default(NULL);
            $table->string('color_text', 50)->nullable()->default(NULL);
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
        Schema::dropIfExists('expense_subcategories');
    }
}
