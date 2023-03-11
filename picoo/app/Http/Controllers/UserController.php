<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\Tag;
use App\Models\User;

class UserController extends Controller
{
    public function userPage ($user_id) {
        $login_user = Auth::user();
        $user = User::where('id',$user_id)->first();
        $pictures = $user->pictures()->paginate(20);
        $param = [
            'login_user' => $login_user,
            'user' => $user,
            'pictures' => $pictures,
            'search_tags' => NULL,
        ];
        return view('userpage',$param);
    }

    public function deleteMyPicture ($user_id, $picture_id) {
        $picture = Picture::find($picture_id)->delete();
        return back();
    }

    public function addFollow ($user_id) {
        $login_user = Auth::user();

        $login_user->follows()->syncWithoutDetaching($user_id);
        return back();
    }

    public function deleteFollow ($user_id) {
        $login_user = Auth::user();

        $login_user->follows()->detach($user_id);
        return back();
    }

    public function favorites () {
        $login_user = Auth::user();
        $favorites = $login_user -> favorites() -> paginate(20);

        $param =[
            'login_user' => $login_user,
            'favorites' => $favorites,
            'search_tags' => NULL,
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
        ];
        return view('follows',$param);
    }
}
