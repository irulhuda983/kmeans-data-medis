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
        Schema::create('rekam_medis', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->string('nama')->nullable();
            $table->enum('jenis_kelamin', ['l', 'p'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->dateTime('tanggal_lahir')->nullable();
            $table->integer('umur')->nullable();
            $table->integer('id_jenis_umur')->nullable();
            $table->string('penyakit')->nullable();
            $table->integer('id_jenis_penyakit')->nullable();
            $table->string('pelayanan')->nullable();
            $table->string('alamat')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};
