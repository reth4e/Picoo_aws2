<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class PictureController extends Controller
{
    public function index(){
        $user = Auth::User();

        return view('index',$user);
    }

    public function postPicture(Request $request)
    {
        $user = Auth::user();
        
        $picture = new Picture;
        $date = Carbon::now();

        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/pictures' , $file_name);
        
        unset($picture['_token']);

        $picture->user_id = $request->user()->id;
        $picture->file_path = 'storage/pictures/' . $file_name;
        $picture->title = $request->title;
        $picture->tag_count = 1;
        $picture->post_comment = $request->post_comment;

        $picture->save();

        $user->last_uploaded = $date;
        $user->save();

        $tag = Tag::firstOrCreate([
            'name' => $request->tag,
        ]);

        return view('index',$user);
    }
}
