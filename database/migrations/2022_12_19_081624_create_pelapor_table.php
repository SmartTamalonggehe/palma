<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePelaporTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelapor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distrik_id')->constrained('distrik')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nama');
            $table->string('no_ktp', 30)->unique();
            $table->string('no_kk', 30);
            $table->string('no_hp', 18);
            $table->text('alamat');
            $table->string('foto_ktp');
            $table->string('foto_kk');
            $table->string('status', 30);
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
        Schema::dropIfExists('pelapor');
    }
}
