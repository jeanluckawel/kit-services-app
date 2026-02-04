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
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id');

            $table->enum('relationship',['Father','Mother','Spouse','Brother','Sister','Mr','Mrs','Dr'])->nullable();
            $table->string('full_name')->nullable();

            $table->string('phone')->nullable();
            $table->string('address')->nullable();

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
        Schema::dropIfExists('emergencies');
    }
};
