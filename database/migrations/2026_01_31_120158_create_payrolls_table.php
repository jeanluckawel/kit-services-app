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
        Schema::create('payrolls', function (Blueprint $table) {
            // Identification de l'employé
            $table->string('employee_id');
            $table->decimal('exchange_rate', 15, 2)->default(2800);

            // Période de paie
            $table->integer('period')->nullable();

            // Info de salaire de base
            $table->decimal('basic_usd', 15, 2)->default(0)->nullable();
            $table->integer('tax_dependants')->default(0)->nullable();
            $table->integer('worked_days')->default(0)->nullable(); // 0-22
            $table->decimal('baremic_salary', 15, 2)->default(0)->nullable();

            // Congés / logement
            $table->integer('sick_days')->default(0)->nullable(); // 0-22
            $table->decimal('accommodation_allowance', 15, 2)->default(0)->nullable();

            // Heures supplémentaires
            $table->decimal('ot_hours_30', 8, 2)->default(0)->nullable();
            $table->decimal('ot_hours_60', 8, 2)->default(0)->nullable();
            $table->decimal('ot_hours_100', 8, 2)->default(0)->nullable();

            // Calculs de paie
            $table->decimal('total_earnings', 15, 2)->default(0)->nullable();
            $table->decimal('inss_5', 15, 2)->default(0)->nullable();
            $table->decimal('monthly_ipr', 15, 2)->default(0)->nullable();
            $table->decimal('ipr_rate', 5, 2)->default(0)->nullable();
            $table->decimal('net', 15, 2)->default(0)->nullable();
            $table->decimal('net_usd', 15, 2)->default(0)->nullable();

            $table->decimal('cnss_13', 15, 2)->default(0)->nullable();
            $table->decimal('inpp_2', 15, 2)->default(0)->nullable();
            $table->decimal('onem_02', 15, 2)->default(0)->nullable();
            $table->decimal('total_taxes_cdf', 15, 2)->default(0)->nullable();

            $table->decimal('kitservice_royalties', 15, 2)->default(0)->nullable();

            // Bases fiscales et tranches
            $table->decimal('inss_tax_base', 15, 2)->default(0)->nullable();
            $table->decimal('ipr_tax_base', 15, 2)->default(0)->nullable();
            $table->decimal('annual_ipr_tax_base', 15, 2)->default(0)->nullable();

            $table->decimal('tranche2', 15, 2)->default(0)->nullable();
            $table->decimal('tranche3', 15, 2)->default(0)->nullable();
            $table->decimal('tranche_gt3', 15, 2)->default(0)->nullable();

            // Paiement
            $table->date('payment_date')->nullable()->nullable();
            $table->enum('status', ['pending', 'paid'])->default('pending')->nullable();
            $table->string('reference')->nullable();
            $table->string('payment_method')->nullable();

            $table->string('start_date');
            $table->string('end_date');
            $table->integer('year')->nullable();
            $table->unique(['employee_id', 'start_date', 'end_date']);



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
        Schema::dropIfExists('payrolls');
    }
};
