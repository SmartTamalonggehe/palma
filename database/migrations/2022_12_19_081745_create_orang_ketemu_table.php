<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrangKetemuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orang_ketemu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orang_hilang_id')->constrained('orang_hilang')->cascadeOnDelete()->cascadeOnUpdate();
            $table->text('alamat_ketemu');
            $table->string('nm_penemu');
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
        Schema::dropIfExists('orang_ketemu');
    }
}
