<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\DB;

class Image extends Model
{
    use HasFactory;

    protected $guarded = [
        "id",
    ];

    /** 
     * Userテーブルとのリレーション
    */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Tagテーブルとのリレーション
     */
    public function tag()
    {
        return $this->hasOne('App\Models\Tag', 'img_id');
    }

    /**
     * DBに画像情報を追加するメソッド  
     */    
    public function imageAdd($user_id, $content, $path){

        $image = new Image;
        $image->user_id = $user_id;
        $image->content = $content;
        $image->src = $path;
        //データの保存に失敗した時、例外をスローする
        $image->saveOrFail();

        return $image;
    }

    /**
     * tagを元に紐づいたイメージを検索するメソッド
     */
    public function imageSearchWithTag($tag){
        $images = Image::whereHas('tag', function ($query) use ($tag) {
            $query->where('tag1', 'like', "%". $tag . "%")
                ->orWhere('tag2', 'like', "%". $tag . "%");
        })
        ->with('tag')
        ->orderBy('updated_at', 'desc')
        ->get();

        return $images;
    }

    /**
     * 投稿履歴を取得するメソッド
     * @param1 ログインしているユーザーID
     * @return 該当するイメージデータ
     */
    public function imageSearchWithId($user_id){
        $images = Image::with("tag", "user")->where("user_id", $user_id)->orderBy("updated_at", "desc")->get();
        return $images;
    }

     /**
     * 投稿履歴を取得するメソッド
     * @param1 ログインしているユーザーID
     * @param2 画像ID
     * @return 該当するイメージデータ
     */
    public function imageSearchWithIdAndImageID($user_id, $img_id){

        $image = Image::with("tag", "user")->where("user_id", $user_id)->where("id", $img_id)->first();
        return $image;
    }

    /**
     * 編集を実行するメソッド
     * @param1 編集するImageデータ
     * @param2 内容
     * @param3 tag1
     * @param4 tag2
     */
    public function imageEdit(Image $image, $content, $tag1, $tag2){
        $image->content = $content;
        $image->tag->tag1 = $tag1;
        $image->tag->tag2 = $tag2;

        $image->saveOrFail();
        $image->tag->saveOrFail();
    }

    /**
     * 指定したImageとTagを削除するメソッド
     */
    public function imageDelete($user_id, $img_id){
        DB::transaction(function () use ($user_id, $img_id) {
            $image = Image::where("user_id", $user_id)->where("id", $img_id)->first();
            if ($image !== null) {
                $image->tag()->delete();
                $image->delete();
            }
        });
    }
}


