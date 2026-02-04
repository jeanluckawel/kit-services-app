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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            $table->string('employee_id');
            $table->string('job_title')->nullable();
            $table->string('department')->nullable();
            $table->string('section')->nullable();

            $table->enum('contract_type', ['CDI', 'CDD', 'Stage', 'Consultant'])->nullable();
            $table->date('hire_date')->nullable();
            $table->date('end_contract_date')->nullable();

            $table->string('work_location')->nullable();
            $table->string('supervisor')->nullable();

            $table->enum('employee_type', ['Full Time', 'Part Time'])->nullable();


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
        Schema::dropIfExists('companies');
    }
};
