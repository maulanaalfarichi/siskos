<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Kamarkosan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kamar_kosan',function (Blueprint $table){
            $table->increments('id');
            $table->integer('id_kosan');
            $table->string('nama',30);
            $table->longText('keterangan');
            $table->integer('harga');
            $table->integer('letak_lantai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
