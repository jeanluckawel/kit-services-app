<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();

            $table->string('employee_id');
            $table->decimal('base_salary', 15, 2)->default(0)->nullable();
            $table->string('category')->nullable();
            $table->string('echelon')->nullable();
            $table->enum('currency', ['USD','CDF'])->default('USD')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('employee_id');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
