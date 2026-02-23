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
        Schema::create('quick_pays', function (Blueprint $table) {
            $table->id();



            $table->string('employee_id');

            $table->decimal('exchange_rate', 15, 2);


            $table->integer('period')->nullable();

            $table->integer('year')->default(now()->year);


            $table->integer('day_sick')->default(0);
            $table->decimal('sick', 15, 2)->default(0);


            $table->integer('day_overtime')->default(0);
            $table->decimal('overtime', 15, 2)->default(0);


            $table->integer('day_work')->default(0);
            $table->decimal('work', 15, 2)->default(0);


            $table->timestamps();
            $table->softDeletes();


            $table->index('employee_id');

            $table->foreign('employee_id')
                ->references('employee_id')
                ->on('employees')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_pays');
    }
};
