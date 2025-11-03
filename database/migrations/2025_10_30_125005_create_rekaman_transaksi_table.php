<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_rekaman_transaksi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('rekaman_transaksi', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED, Primary Key, Auto-Increment (kolom 'id')
            // Foreign Key ke tabel 'pelanggan', merujuk ke kolom 'ID_Pelanggan'
            $table->unsignedBigInteger('pelanggan_id');
            $table->foreign('pelanggan_id')
                  ->references('ID_Pelanggan') // Kolom tujuan
                  ->on('pelanggan')             // Tabel tujuan
                  ->onDelete('cascade');

            $table->string('id_transaksi_input'); // Input dari pelanggan
            // Foreign Key ke tabel 'transaksi', one-to-one, unik, merujuk ke 'ID_Transaksi'
            $table->string('transaksi_id')->nullable()->unique();
            $table->foreign('transaksi_id')
                  ->references('ID_Transaksi') // Kolom tujuan sekarang adalah 'ID_Transaksi'
                  ->on('transaksi')             // Tabel tujuan
                  ->onDelete('set null'); // Jika transaksi dihapus, rekaman tetap ada

            $table->boolean('diskon_diberikan')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('rekaman_transaksi');
    }
};