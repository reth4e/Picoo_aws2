<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\Picture;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
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
            $set_user_id = User::select('id')->orderByRaw("RAND()")->first()->id;

            DB::table('comments')->insert([
                'user_id' => $set_user_id,
                'picture_id' => $set_picture_id,
                'content' => 'サンプルコメント' . $cnt,
            ]);
        }
    }
}
