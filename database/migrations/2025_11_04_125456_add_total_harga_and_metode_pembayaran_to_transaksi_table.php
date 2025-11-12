<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Tambahkan kolom TotalHarga
            $table->float('TotalHarga', 20)->nullable(); // Gunakan nullable() jika tidak selalu wajib diisi saat pembuatan transaksi

            // Tambahkan kolom MetodePembayaran
            $table->enum('MetodePembayaran', ['QRIS', 'CASH'])->nullable(); // Gunakan nullable() jika tidak selalu wajib diisi saat pembuatan transaksi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Hapus kolom saat rollback
            $table->dropColumn('TotalHarga');
            $table->dropColumn('MetodePembayaran');
        });
    }
};