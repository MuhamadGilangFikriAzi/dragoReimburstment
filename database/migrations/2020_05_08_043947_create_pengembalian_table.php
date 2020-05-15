<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePengembalianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user');
            $table->string('asal_dana', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('tipe_pengembalian', ['langsung', 'transfer'])->nullable();
            $table->enum('status', ['Diberikan', 'Dikembalikan']);
            $table->double('total_dikembalikan')->nullable();
            $table->double('total_asal_dana')->nullable();
            $table->double('total_digunakan')->nullable();
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
        Schema::dropIfExists('pengembalian');
    }
}
