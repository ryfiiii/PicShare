<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [
        "id",
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function tag()
    {
        return $this->hasOne('App\Models\Tag', 'img_id');
    }
}
