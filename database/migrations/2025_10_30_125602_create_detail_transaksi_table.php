<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_detail_transaksi_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED, Primary Key, Auto-Increment (kolom 'id')
            // Foreign Key ke tabel 'transaksi', merujuk ke kolom 'ID_Transaksi'
            $table->string('transaksi_id'); // Tipe harus sesuai dengan ID_Transaksi
            $table->foreign('transaksi_id')
                  ->references('ID_Transaksi') // Kolom tujuan sekarang adalah 'ID_Transaksi'
                  ->on('transaksi')             // Tabel tujuan
                  ->onDelete('cascade');

            // Foreign Key ke tabel 'produk', merujuk ke kolom 'id' (default)
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');

            $table->integer('jumlah');
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_transaksi');
    }
};