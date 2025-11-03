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

            // Foreign Key ke tabel 'pelanggan', merujuk ke kolom 'ID_Pelanggan'
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')
                  ->references('ID_Pelanggan') // Kolom tujuan
                  ->on('pelanggan')             // Tabel tujuan
                  ->onDelete('cascade');

            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
};