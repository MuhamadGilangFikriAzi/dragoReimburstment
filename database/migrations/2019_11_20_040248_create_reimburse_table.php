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
        Schema::create('reimburse', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title',50)->nullable();
            $table->string('staff',50)->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();
            $table->double('total')->nullable();
            $table->text('proof')->nullable();
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
