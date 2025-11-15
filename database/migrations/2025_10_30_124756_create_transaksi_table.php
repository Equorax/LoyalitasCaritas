<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_transaksi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            // Gunakan string dengan nama kolom 'ID_Transaksi' dan jadikan primary key
            $table->string('ID_Transaksi')->primary();
            // Foreign Key ke tabel 'karyawan', merujuk ke kolom 'ID_Karyawan'
            $table->unsignedBigInteger('karyawan_id');
            $table->foreign('karyawan_id')
                  ->references('ID_Karyawan') // Kolom tujuan
                  ->on('karyawan')             // Tabel tujuan
                  ->onDelete('cascade');


            $table->string('redeem_status')->default('unredeemed'); // status redeem
            $table->float('TotalHarga', 20)->nullable(); // Gunakan nullable() jika tidak selalu wajib diisi saat pembuatan transaksi

            // Tambahkan kolom MetodePembayaran
            $table->enum('MetodePembayaran', ['QRIS', 'CASH'])->nullable();

            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};