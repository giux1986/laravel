<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
 		$this->call('UserTableSeeder');
		// $this->call('UserTableSeeder');
	}
	

}
class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(['email' => 'giux1986@gmail.com','name' => 'test','password' => bcrypt('test')]);
    }
}
