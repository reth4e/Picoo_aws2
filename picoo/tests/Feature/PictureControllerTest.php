<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Picture;
use App\Models\User;
use App\Models\Tag;
use App\Models\Comment;

class PictureControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testIndex()
    {
        $login_user = User::factory()->create();
        $response = $this->actingAs($login_user);
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testPostPicture()
    {
        $login_user = User::factory()->create();
        $another_user = User::factory()->create();
        
    }
}
