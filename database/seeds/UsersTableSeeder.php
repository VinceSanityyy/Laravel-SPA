<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 5000; $i++) {
	    	User::create([
	            'name' => str_random(8),
	            'email' => str_random(12).'@mail.com',
                'password' => bcrypt('123456'),
                'bio' => str_random(10),
                'photo' => str_random(5),
                'type' => str_random(5),
	        ]);
    	}
    }

}
