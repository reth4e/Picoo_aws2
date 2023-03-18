<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = array('id');

    protected $fillable = [
        'name',
    ];

    public function pictures()
    {
        return $this->belongsToMany('App\Models\Picture');
    }

    public static function getTagToArray ($input_tag)
    {
        $input_tag = str_replace('　', ' ', $input_tag);
        //複数の半角スペースを単一の半角スペースにする
        $input_tag = preg_replace('/\s+/', ' ', $input_tag);
        $input_tag_to_array = explode(' ', $input_tag);

        return $input_tag_to_array;
    }
}
