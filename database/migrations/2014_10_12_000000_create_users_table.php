<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nik',20)->unique();
            $table->string('username',15)->unique();
            $table->string('displayname',75);
            $table->string('password');
            $table->date('tgl_lahir');
            $table->char('jenis_kelamin',1)->default('L');
            $table->string('alamat',100);
            $table->boolean('perorangan')->default(0);
            $table->boolean('keluarga')->default(0);
            <<<<
            <<< Updated upstream
=======
            $table->boolean('suspended')->default(0);
>>>>>>> Stashed changes
            $table->string('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user');
    }

}
