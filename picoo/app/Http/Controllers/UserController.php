<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\User;

class UserController extends Controller
{
    public function userPage ($user_id) {
        $login_user = Auth::user();
        $user = User::find($user_id);
        $pictures = $user -> pictures() -> paginate(20);
        $param = [
            'login_user' => $login_user,
            'user' => $user,
            'pictures' => $pictures,
            'search_tags' => NULL,
            'notifications' => $login_user -> unreadNotifications() -> paginate(5),
        ];
        return view('userpage',$param);
    }

    public function deleteMyPicture ($user_id, $picture_id) {
        $picture = Picture::find($picture_id) -> delete();
        return back();
    }

    public function addFollow ($user_id) {
        $login_user = Auth::user();

        $login_user -> follows() -> syncWithoutDetaching($user_id);

        $user = User::find($user_id);
        $user -> followers_count = count($user -> followers);
        $user -> save();
        return back();
    }

    public function deleteFollow ($user_id) {
        $login_user = Auth::user();

        $login_user -> follows() -> detach($user_id);

        $user = User::find($user_id);
        $user -> followers_count = count($user -> followers);
        $user -> save();
        return back();
    }

    public function favorites () {
        $login_user = Auth::user();
        $favorites = $login_user -> favorites() -> paginate(20);

        $param =[
            'login_user' => $login_user,
            'favorites' => $favorites,
            'search_tags' => NULL,
            'notifications' => $login_user -> unreadNotifications() -> paginate(5),
        ];
        return view('favorites',$param);
    }

    public function follows () {
        $login_user = Auth::user();
        $follows = $login_user -> follows() -> paginate(20);
        
        $param =[
            'login_user' => $login_user,
            'follows' => $follows,
            'search_tags' => NULL,
            'notifications' => $login_user -> unreadNotifications() -> paginate(5),
        ];
        return view('follows',$param);
    }

    public function addNg ($user_id) {
        $login_user = Auth::user();
        $login_user -> ngUsers() -> syncWithoutDetaching($user_id);

        return back();
    }

    public function deleteNg ($user_id) {
        $login_user = Auth::user();
        $login_user -> ngUsers() -> detach($user_id);

        return back();
    }

    public function changeIcon (Request $request) {
        $login_user = Auth::user();
        $icon_name = $request -> file('image') -> getClientOriginalName();
        $request -> file('image') -> storeAs('public/icons' , $icon_name);

        $login_user -> icon_path = 'storage/icons/' . $icon_name;
        unset($login_user['_token']);
        $login_user -> save();
        return back();
    }

    public function read (Request $request) {
        $login_user = Auth::user();
        $notification = $login_user -> notifications() -> find($request -> notification_id);
        $notification -> markAsRead();

        return back();
    }

    public function readAll () {
        auth() -> user() -> unreadNotifications -> markAsRead();

        return back();
    }
}
