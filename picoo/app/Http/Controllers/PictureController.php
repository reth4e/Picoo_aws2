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
        $param = [
            'user' => $user,
            'search_tags' => NULL,
        ];

        return view('index',$param);
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
        //複数の半角スペースを単一の半角スペースにする
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

        $param = [
            'user' => $user,
            'search_tags' => NULL
        ];
        return view('index',$param);
    }


    public function searchPictures(Request $request) {
        $user = Auth::user();

        $searched_tag = $request->contents;
        $searched_tag = str_replace('　', ' ', $searched_tag);
        //複数の半角スペースを単一の半角スペースにする
        $searched_tag = preg_replace('/\s+/', ' ', $searched_tag);
        $searched_tag_array = explode(' ', $searched_tag);
        

        $pictures = Picture::all();
        $picture_ids = [];
        foreach($pictures as $picture) {
            $duplicates = 0;
            $tags = $picture->tags;
            foreach($searched_tag_array as $value) {
                foreach($tags as $tag) {
                    if(strpos($tag,(string)$value) !== false) {
                        $duplicates++;
                        continue 2;
                    }
                }
            }
            //検索ワードの文字数が特定の1文字(a,e,rなど)のときに検索不具合　次回以降の課題
            //strposの不具合か？
            if($duplicates === count($searched_tag_array)) {
                array_push($picture_ids,$picture->id);
            }
        }

        $search_result = Picture::whereIn('id',$picture_ids)->paginate(20);
        
        $param = [
            'user' => $user,
            'pictures' => $search_result,
            'search_tags' => $searched_tag,
        ];
        return view('pictures',$param);
    }

    public function picturePage(Request $request) {
        $user = Auth::user();
        $picture = Picture::where('id',$request->picture_id)->first();
        $tags = $picture->tags;
        $param = [
            'user' => $user,
            'picture' => $picture,
            'tags' => $tags,
            'search_tags' => NULL,
        ];
        return view('picturepage',$param);
    }
}
