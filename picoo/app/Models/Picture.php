<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    protected $fillable = [
        'title',
        'post_comment',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function usersWhoLike ()
    {
        return $this->belongsToMany('App\Models\User', 'likes', 'picture_id', 'user_id');
    }

    public static function getPictureIds ($pictures ,$searched_tag_array)
    {
        $picture_ids = [];
        foreach($pictures as $picture) {
            $duplicates = 0;
            $tags = $picture -> tags;
            foreach($searched_tag_array as $value) {
                $required_tags = Tag::where('name','LIKE',"%{$value}%")->get();
                foreach($required_tags as $required_tag) {
                    foreach($tags as $tag) {
                        if($tag -> name === $required_tag -> name) {
                            $duplicates++;
                            break;
                        }
                    }
                }
            }
            if($duplicates === count($searched_tag_array)) {
                array_push($picture_ids,$picture -> id);
            }
        }

        return $picture_ids;
    }
}
