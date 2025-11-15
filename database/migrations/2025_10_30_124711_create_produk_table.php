<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED, Primary Key, Auto-Increment (kolom 'id')
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 2);
            $table->string('kategori', 20)->nullable(); // Gunakan nullable() jika tidak selalu wajib diisi saat pembuatan produk
            $table->timestamps();
            
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};