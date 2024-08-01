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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('avatar');
            $table->string('alamat')->nullable()->after('nik');
            $table->string('nomor_telepon')->nullable()->after('alamat');
            $table->date('tanggal_lahir')->nullable()->after('nomor_telepon');
            $table->string('pekerjaan')->nullable()->after('tanggal_lahir');
            $table->string('penghasilan')->nullable()->after('pekerjaan');
            $table->string('ktp')->nullable()->after('penghasilan');
            $table->string('kartu_keluarga')->nullable()->after('ktp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'alamat', 'nomor_telepon', 'tanggal_lahir', 'pekerjaan', 'penghasilan', 'ktp', 'kartu_keluarga']);
        });
    }
};
