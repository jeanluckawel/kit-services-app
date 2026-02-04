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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');
            $table->string('number')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();

            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('emergency_phone')->nullable();

            $table->index('employee_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
