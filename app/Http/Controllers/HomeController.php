<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostValidate;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * ログイン認証
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * ホーム画面
     */
    public function index()
    {
        //ImageとTagとUserのリレーションで、Imageとそれに紐づいたタグの情報を取得
        $images = Image::with("tag", "user")->orderBy("updated_at", "desc")->paginate(6);

        return view('home', compact("images"));
    }

    /**
     * 投稿された時の処理
     */
    public function post(PostValidate $request){

        //ファイルをpublicのuploadsに保存した後、保存後のPathを取得
        $path = $request->file("image")->store("uploads", "public");
        
        //DBに画像情報を保存
        $image = Image::create([
            "user_id" => Auth::user()->id,
            "content" => $request->content,
            "src" => $path,
        ]);

        //フォームにタグが入力されていた場合はDBにタグ情報を保存
        if(!empty($request->tag1) && empty($request->tag2) ){
            Tag::create([
                "img_id" => $image->id,
                "tag1" => $request->tag1,
                "tag2" => null,
            ]);

        }elseif(empty($request->tag1) && !empty($request->tag2)){
            Tag::create([
                "img_id" => $image->id,
                "tag1" => null,
                "tag2" => $request->tag2,
            ]);

        }elseif(!empty($request->tag1) && !empty($request->tag2)){
            Tag::create([
                "img_id" => $image->id,
                "tag1" => $request->tag1,
                "tag2" => $request->tag2,
            ]);
        }
        
        return redirect("home")->with("uploadSuccess", "success!");
    }

    /**
     * 検索された時の処理
     */
    public function search(Request $request){

        //GETパラメーターを取得
        $tag = $request->input("tags");

        //フォームが空の時は、ホーム画面に遷移
        if(empty($tag)){
            return redirect("home");
        }

        //リレーションを使ってTagと紐づいたImageを検索
        $images = Tag::where("tag1", "like", "%". $tag . "%")
            ->orWhere("tag2", "like", "%". $tag . "%")
            ->with("image")
            ->get()
            ->pluck('image');

        return view('home', compact("images"));
    }
}
