<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimburseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimburstment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_user');
            $table->enum('tipe_pengembalian', ['langsung', 'transfer', 'pengembalian']);
            $table->string('asal_dana', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->enum('status', ['Diajukan', 'Diterima', 'Ditolak']);
            $table->double('total');
            $table->double('total_asal_dana')->nullable();
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
        Schema::dropIfExists('reimburse');
    }
}
