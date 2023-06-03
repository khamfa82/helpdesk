<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // creating an user
        //$str = 'demopass';
        $str = 'admin@demo';

        $password = \Hash::make($str);
        $user = User::create([
            'first_name'   => 'System',
            'last_name'    => 'Administrator',
            'email'        => 'faveo@example.com',
            'user_name'    => 'admin',
            'password'     => $password,
            'assign_group' => 1,
            'primary_dpt'  => 1,
            'active'       => 1,
            'role'         => 'admin',
        ]);

        // $user = User::create([
        //     'first_name'   => 'Alfred',
        //     'last_name'    => 'King',
        //     'email'        => 'king@example.com',
        //     'user_name'    => 'user1',
        //     'password'     => $password,
        //     'assign_group' => 1,
        //     'primary_dpt'  => 1,
        //     'active'       => 1,
        //     'role'         => 'agent',
        // ]);

        // $user = User::create([
        //     'first_name'   => 'Julian',
        //     'last_name'    => 'Wagle',
        //     'email'        => 'wagle@example.com',
        //     'user_name'    => 'user2',
        //     'password'     => $password,
        //     'assign_group' => 1,
        //     'primary_dpt'  => 1,
        //     'active'       => 1,
        //     'role'         => 'agent',
        // ]);

        // $user = User::create([
        //     'first_name'   => 'Miriam',
        //     'last_name'    => 'Odemba',
        //     'email'        => 'odemba@example.com',
        //     'user_name'    => 'user3',
        //     'password'     => $password,
        //     'assign_group' => 1,
        //     'primary_dpt'  => 1,
        //     'active'       => 1,
        //     'role'         => 'agent',
        // ]);

        // $user = User::create([
        //     'first_name'   => 'John',
        //     'last_name'    => 'Snow',
        //     'email'        => 'snow@example.com',
        //     'user_name'    => 'user4',
        //     'password'     => $password,
        //     'assign_group' => 1,
        //     'primary_dpt'  => 1,
        //     'active'       => 1,
        //     'role'         => 'agent',
        // ]);
        
        // checking if the user have been created
    }
}
