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
}
