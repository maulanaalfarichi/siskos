<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
			'nik' => '15051204010',
			'email' => 'bagashidayat45@gmail.com',
			'username' => 'BagasMuharom',
			'displayname' => 'Bagas Muharom Hanugrah Hidayat',
			'password' => bcrypt('Smadia123'),
			'tg_lahir' => '1997-05-12',
			'jenis_kelamin' => 'L',
			'alamat' => 'Jl. Karang Rejo III No. 9',
			'perorangan' => 0,
			'pelajar' => 1,
			'keluarga' => 0,
			'remember_token' => str_random(10)
		]);
    }
}
