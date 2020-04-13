<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReimburstmentDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reimburstment_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('reimburstment_id');
            $table->string('prihal', 50);
            $table->double('digunakan');
            $table->string('foto', 255);
            $table->text('deskripsi');
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
        Schema::dropIfExists('reimburstment_detail');
    }
}
