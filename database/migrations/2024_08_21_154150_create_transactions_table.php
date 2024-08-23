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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date'); // Tanggal transaksi
            $table->string('description'); // Uraian transaksi
            $table->decimal('debit', 15, 2)->nullable(); // Uang masuk
            $table->decimal('credit', 15, 2)->nullable(); // Uang keluar
            $table->decimal('balance', 15, 2)->nullable(); // Saldo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
