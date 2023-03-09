<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Picture;
use App\Models\Tag;
use App\Models\Comment;
use Carbon\Carbon;
use App\Http\Requests\PictureRequest;
use App\Http\Requests\CommentRequest;

class PictureController extends Controller
{

    public function index(){
        $login_user = Auth::user();
        $param = [
            'login_user' => $login_user,
            'search_tags' => NULL,
        ];

        return view('index',$param);
    }

    public function postPicture(PictureRequest $request)
    {
        $login_user = Auth::user();
        $picture = new Picture;
        $date = Carbon::now();

        $file_name = $request->file('image')->getClientOriginalName();
        $request->file('image')->storeAs('public/pictures' , $file_name);
        
        unset($picture['_token']);


        $login_user->last_uploaded = $date;
        $login_user->save();


        $input_tag = $request->tags;
        $input_tag = str_replace('　', ' ', $input_tag);
        //複数の半角スペースを単一の半角スペースにする
        $input_tag = preg_replace('/\s+/', ' ', $input_tag);

        $tag_ids = [];
        $input_tag_to_array = explode(' ', $input_tag);
        if(count($input_tag_to_array)>10){
            return back();
        }

        foreach($input_tag_to_array as $tag){
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
        $picture->tag_count = count($input_tag_to_array);
        $picture->post_comment = $request->post_comment;
        $picture->save();


        $picture->tags()->syncWithoutDetaching($tag_ids);

        $param = [
            'login_user' => $login_user,
            'search_tags' => NULL
        ];
        return view('index',$param);
    }


    public function searchPictures(Request $request) {
        $login_user = Auth::user();

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
            'login_user' => $login_user,
            'pictures' => $search_result,
            'search_tags' => $searched_tag,
        ];
        return view('pictures',$param);
    }

    public function picturePage(Request $request) {
        $login_user = Auth::user();
        $picture = Picture::where('id',$request->picture_id)->first();
        $tags = $picture->tags;
        $comments = Comment::where('picture_id',$request->picture_id)->orderBy('id','desc')->paginate(10);

        $param = [
            'login_user' => $login_user,
            'picture' => $picture,
            'tags' => $tags,
            'comments' => $comments,
            'search_tags' => NULL,
        ];
        return view('picturepage',$param);
    }

    public function insertTag ($picture_id, Request $request) {
        $picture = Picture::where('id',$picture_id)->first();
        $input_tag = $request->tags;
        $input_tag = str_replace('　', ' ', $input_tag);
        //複数の半角スペースを単一の半角スペースにする
        $input_tag = preg_replace('/\s+/', ' ', $input_tag);

        $tag_ids = [];
        $input_tag_to_array = explode(' ', $input_tag);
        if(count($input_tag_to_array) + $picture->tag_count > 10){
            return back();
        }
        foreach($input_tag_to_array as $tag){
            if(strlen($tag) > 20){
                return back();
            }
            $tag = Tag::firstOrCreate([
                'name' => $tag,
            ]);
            array_push($tag_ids, $tag->id);
        }

        $picture->tags()->syncWithoutDetaching($tag_ids);
        $tag_count = count($picture->tags);
        $picture->tag_count = $tag_count;
        $picture->save();

        return back();
    }

    public function deleteTag ($picture_id,$tag_id) {
        $picture = Picture::where('id',$picture_id)->first();
        $picture->tags()->detach($tag_id);
        $tag_count = count($picture->tags);
        $picture->tag_count = $tag_count;
        $picture->save();

        return back();
    }

    public function changeTitle ($picture_id, PictureRequest $request) {
        $picture = Picture::where('id',$picture_id)->first();
        $picture->title = $request->title;
        $picture->save();
        return back();
    }

    public function changePostComment ($picture_id, PictureRequest $request) {
        $picture = Picture::where('id',$picture_id)->first();
        $picture->post_comment = $request->post_comment;
        $picture->save();
        return back();
    }

    public function addComment ($picture_id, CommentRequest $request) {
        $picture = Picture::where('id',$picture_id)->first();
        $login_user = Auth::user();

        $comment = new Comment;
        $comment->content = $request->comment;
        $comment->user_id = $request->user()->id;
        $comment->picture_id = $picture_id;
        $comment->save();

        return back();
    }
}
