<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrangHilangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orang_hilang', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelapor_id')->constrained('pelapor')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama');
            $table->smallInteger('umur');
            $table->string('no_ktp', 30)->nullable();
            $table->string('no_kk', 30)->nullable();
            $table->string('no_hp', 18)->nullable();
            $table->string('suku');
            $table->string('tinggi');
            $table->string('berat');
            $table->string('warna_rambut');
            $table->string('jenis_rambut');
            $table->string('warna_kulit');
            $table->string('pakaian_terakhir');
            $table->string('foto');
            $table->text('hubungan');
            $table->text('alamat');
            $table->date('tgl_hilang');
            $table->string('status', 30); // diterima, diproses, ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orang_hilang');
    }
}
