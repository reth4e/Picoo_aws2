<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Picture;
use App\Models\Tag;

class PictureTagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for( $cnt = 1; $cnt <= 10; $cnt++ ) { 
            $set_picture_id = Picture::select('id')->orderByRaw("RAND()")->first()->id;
            $set_tag_id = Tag::select('id')->orderByRaw("RAND()")->first()->id;

            $picture_tag = DB::table('picture_tag')
                            ->where([
                                ['picture_id', '=', $set_picture_id],
                                ['tag_id', '=', $set_tag_id]
                            ])->get();

            if($picture_tag->isEmpty()){
                DB::table('picture_tag')->insert(
                    [
                        'picture_id' => $set_picture_id,
                        'tag_id' => $set_tag_id,
                    ]
                );
            }else{
                $cnt--;
            }
        }
    }
}
