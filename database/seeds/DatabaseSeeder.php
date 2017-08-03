<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(App\User::where(['email' => config('admin.account.email')])->count() == 0)
        {
            $user = App\User::create([
                'email'     => config('admin.account.email'),
                'firstname' => config('admin.account.firstname'),
                'lastname'  => config('admin.account.lastname'),
                'username'  => str_replace('@butler.edu', '', config('admin.account.email')),
                'password'  => bcrypt(str_random(32))
            ]);
            $user->assignRole('admin');
        }
    }
}
