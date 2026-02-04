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
        Schema::create('childrens', function (Blueprint $table) {
            $table->id();

            $table->string('employee_id');
            $table->string('full_name')->nullable();;

            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['M', 'F'])->nullable();

            $table->timestamps();

            $table->index('employee_id');

            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('childrens');
    }
};
