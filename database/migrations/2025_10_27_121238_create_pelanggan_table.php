<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('ID_Pelanggan'); // Sesuai ERD
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('Nama_Pelanggan', 30);
            $table->string('Email_Pelanggan', 100);
            $table->integer('Frekuensi_Pembelian')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pelanggan');
    }
};