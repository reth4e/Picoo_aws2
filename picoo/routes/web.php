<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware' => 'auth'],function() {
    Route::get('/', [PictureController::class, 'index']);
    Route::post('/', [PictureController::class, 'postPicture']);
    Route::post('/pictures/{picture_id}/tag',[PictureController::class, 'insertTag']);
    Route::delete('/pictures/{picture_id}/tag/{tag_id}',[PictureController::class, 'deleteTag']);
    Route::put('/pictures/{picture_id}/title',[PictureController::class, 'changeTitle']);
    Route::put('/pictures/{picture_id}/post_comment',[PictureController::class, 'changePostComment']);
    Route::post('/pictures/{picture_id}/comment',[PictureController::class, 'addComment']);
    Route::put('/pictures/{picture_id}/comment/{comment_id}',[PictureController::class, 'updateComment']);
    Route::delete('/pictures/{picture_id}/comment/{comment_id}',[PictureController::class, 'deleteComment']);
    Route::get('/pictures/{picture_id}/add_like', [PictureController::class, 'addLike']);
    Route::get('/pictures/{picture_id}/delete_like', [PictureController::class, 'deleteLike']);
    Route::get('/user/{user_id}/add_follow',[UserController::class, 'addFollow']);
    Route::get('/user/{user_id}/delete_follow',[UserController::class, 'deleteFollow']);
    Route::get('/user/favorites',[UserController::class, 'favorites']);
    Route::get('/user/follows',[UserController::class, 'follows']);
    Route::get('/user/{user_id}/add_ng',[UserController::class, 'addNg']);
    Route::get('/user/{user_id}/delete_ng',[UserController::class, 'deleteNg']);
});

Route::get('/pictures',[PictureController::class, 'searchPictures']);
Route::get('/pictures/{picture_id}',[PictureController::class, 'picturePage']);


Route::get('/user/{user_id}',[UserController::class, 'userPage']);
Route::delete('/user/{user_id}/picture/{picture_id}',[UserController::class, 'deleteMyPicture']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
