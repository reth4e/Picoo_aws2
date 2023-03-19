<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $cnt = 1; $cnt <= 10; $cnt++ ) { 
            Tag::create([
                'name' => 'サンプルタグ' . $cnt,
            ]);
        }
    }
}
