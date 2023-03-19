<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $cnt = 1; $cnt <= 10; $cnt++ ) { 
            User::create([
                'name' => 'サンプルユーザー' . $cnt,
                'email' => 'sample' .$cnt . '@example.com',
                'password' => Hash::make('sample00'),
                'followers_count' => 0,
                'icon_path' => 'storage/icons/'.$cnt .'.jpg',
            ]);
        }
    }
}
