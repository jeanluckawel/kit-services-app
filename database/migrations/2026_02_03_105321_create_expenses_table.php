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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->string('user');


            $table->unsignedBigInteger('expense_type_id');

            $table->string('description')->nullable();
            $table->decimal('amount', 15, 2);
            $table->string('file')->nullable();
            $table->enum('currency', ['USD','CDF']);
            $table->string('code')->unique();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('expense_type_id')
                ->references('id')
                ->on('expense__types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
