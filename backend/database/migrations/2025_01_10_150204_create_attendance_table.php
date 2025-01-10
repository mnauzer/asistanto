<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('employee_id'); // FK to employees
            $table->date('date'); // Date of attendance
            $table->time('check_in'); // Check-in time
            $table->time('check_out')->nullable(); // Check-out time
            $table->decimal('hours_worked', 5, 2)->nullable(); // Total hours worked
            $table->timestamps(); // created_at, updated_at

            // Foreign key constraint
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendance');
    }
};
