<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Picture;

class PicturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $cnt = 1; $cnt <= 10; $cnt++ ) { 
            Picture::create([
                'user_id' => $cnt,
                'file_name' => $cnt .'.jpg',
                'file_path' => 'storage/pictures/'.$cnt .'.jpg',
                'title' => 'sampletitle',
                'tag_count' => 0,
                'post_comment' => 'samplecomment.',
                'favorites_count' => 0,
            ]);
        }
    }
}
