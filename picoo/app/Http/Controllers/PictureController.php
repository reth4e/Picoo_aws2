<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Requests\PictureRequest;

class PictureController extends Controller
{
    public function index(){
        $user = Auth::User();

        return view('index',$user);
    }

    public function postPicture(PictureRequest $request)
    {
        $user = Auth::user();
        $picture = new Picture;
        $date = Carbon::now();

        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/pictures' , $file_name);
        
        unset($picture['_token']);


        $user->last_uploaded = $date;
        $user->save();


        $input_tag = $request->tags;
        $input_tag = str_replace('　', ' ', $input_tag);
        $input_tag = preg_replace('/\s+/', ' ', $input_tag);

        $tag_ids = [];
        $tags = explode(' ', $input_tag);
        if(count($tags)>10){
            return back();
        }

        foreach($tags as $tag){
            if(strlen($tag)>20){
                return back();
            }
            $tag = Tag::firstOrCreate([
                'name' => $tag,
            ]);
            array_push($tag_ids, $tag->id);
        }


        $picture->user_id = $request->user()->id;
        $picture->file_path = 'storage/pictures/' . $file_name;
        $picture->title = $request->title;
        $picture->tag_count = count($tags);
        $picture->post_comment = $request->post_comment;
        $picture->save();


        $picture->tags()->syncWithoutDetaching($tag_ids);

        return view('index',$user);
    }
}
