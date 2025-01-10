<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('employee_number')->unique(); // Unique employee number
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nickname')->unique(); // Human-readable unique identifier
            $table->enum('position', ['manager', 'employee', 'intern', 'external']);
            $table->boolean('is_active')->default(true); // Whether the employee is active
            $table->unsignedBigInteger('address_id')->nullable(); // FK to addresses (if used)
            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
};

