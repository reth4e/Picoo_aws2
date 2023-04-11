<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Picture;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;
use Illuminate\Http\UploadedFile;
use App\Notifications\PictureNotification;
use Illuminate\Support\Facades\Notification;


class PictureControllerTest extends TestCase
{   //PictureControllerの各アクションについてのテスト
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $login_user = User::factory() -> create();
        $response = $this -> actingAs($login_user);
        $response = $this -> get('/');

        $response->assertStatus(200);
    }

    public function testPostPicture()
    {
        $another_user = User::factory() -> create();
        $login_user = User::factory() -> create();
        $another_user -> follows() -> syncWithoutDetaching($login_user->id);
        $login_user -> followers_count = count($login_user -> followers);
        $login_user -> save();
        //通知のためのフォロワーを用意

        Notification::fake();
        
        $image = UploadedFile::fake() -> image('item.jpg');
        $tags = 'tag1 tag2 tag3';
        $data = [
            'image' => $image,
            'title' => 'title',
            'post_comment' => 'post_comment',
            'tags' => $tags,
        ];

        $response = $this -> actingAs($login_user);
        $response = $this -> post('/',$data);

        $this -> assertDatabaseHas('pictures', [
            'file_name' => 'item.jpg',
            'tag_count' => 3,
        ]);
        //picturesテーブルのレコードに正しく画像ファイル名が登録されているか確認
        //同時にタグ数が正しく登録されているかを確認し、画像とタグが結び付けられているかをテスト

        $this -> assertDatabaseHas('tags', [
            'name' => 'tag1'
        ]);
        $this -> assertDatabaseHas('tags', [
            'name' => 'tag2'
        ]);
        $this -> assertDatabaseHas('tags', [
            'name' => 'tag3'
        ]);

        Notification::assertTimesSent(
            1,
            PictureNotification::class
        );
    }

    public function testSearchPictures ()
    {
        $login_user = User::factory() -> create();

        $tags = 'tag1 tag2 tag3';
        $image = UploadedFile::fake() -> image('item.jpg');
        $data = [
            'image' => $image,
            'title' => 'title',
            'post_comment' => 'post_comment',
            'tags' => $tags,
        ];
        $response = $this -> actingAs($login_user);
        $response = $this -> post('/',$data);
        
        $response = $this -> get('/pictures',['contents' => 'tag1 tag2 tag3'])->assertSee('item.jpg');

    }
}
