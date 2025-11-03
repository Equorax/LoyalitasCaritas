<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id('ID_Karyawan'); // Sesuai ERD
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('Nama_Karyawan', 50);
            $table->string('Username', 30)->unique();
            $table->string('Email_Karyawan', 100);
            $table->string('Nomor_Hp', 12); // Kolom nomor telpon untuk karyawan ditambahkan
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('karyawan');
    }
};