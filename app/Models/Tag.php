<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class Tag extends Model
{
    use HasFactory;

    protected $primaryKey = "img_id";

    public $timestamps = false;
    
    protected $guarded = [
    ];

    /**
     * Imageモデルとのリレーション
     */
    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'img_id');
    }

    /**
     * Tagを追加するメソッド
     */
    public function tagAdd($tag1, $tag2, Image $image){
        $tag = new Tag;
        $tag->img_id = $image->id;
        $tag->tag1 = !empty($tag1) ? $tag1 : null;
        $tag->tag2 = !empty($tag2) ? $tag2 : null;
        //データの保存に失敗した時、例外をスローする
        $tag->saveOrFail();
    }
}
