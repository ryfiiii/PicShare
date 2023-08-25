<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditValidate;
use Illuminate\Http\Request;
use App\Http\Requests\PostValidate;
use App\Models\User;
use App\Models\Image;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

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

        $tag1 = $request->tag1;
        $tag2 = $request->tag2;
        $user_id = Auth::User()->id;
        $content = $request->content;

        //ファイルをpublicのuploadsに保存した後、保存後のPathを取得
        $path = $request->file("image")->store("uploads", "public");

        DB::beginTransaction();
        try {
            //Image情報をImage情報を保存
            $image = new Image();
            $imageAdd = $image->imageAdd($user_id, $content, $path);

            //Tag情報をTagテーブルに保存
            $tag = new Tag();
            $tag->tagAdd($tag1, $tag2, $imageAdd);

            DB::commit();
            return $this->redirectWithMessage("home", "success", "投稿しました！");

        }catch(Exception $e){

            DB::rollback();
            return $this->redirectWithMessage("home", "danger", "エラー： {$e->getMessage()}");
        }
    }

    /**
     * 検索された時の処理
     */
    public function search(Request $request){

        //GETパラメーターを取得
        $tag = $request->tags;

        //フォームが空の時は、ホーム画面に遷移
        if(empty($tag)){
            return redirect("home");
        }

        //リレーションを使ってTagと紐づいたImageを検索
        $image = new Image();
        $images = $image->imageSearchWithTag($tag);

        return view('home', compact("images"));
    }

    /**
     * 投稿履歴
     */
    public function history() {

        $user_id = Auth::user()->id;
        $image = new Image();
        $images = $image->imageSearchWithId($user_id);

        return view("history", compact("images"));
    }

    /**
     * Editページへ遷移
     */
    public function edit(Request $request){

        $user_id = Auth::user()->id;
        $img_id = $request->id;
        $image = new Image();
        $image = $image->imageSearchWithIdAndImageID($user_id, $img_id);

        return view("edit", compact("image"));
    }

    /**
     * Edit実行
     */
    public function executeEdit(EditValidate $request){
        $user_id = Auth::user()->id;
        $img_id = $request->id;
        $content = $request->content;
        $tag1 = $request->tag1;
        $tag2 = $request->tag2;

        DB::beginTransaction();
        try{
            $image = new Image();
            $image = $image->imageSearchWithIdAndImageID($user_id, $img_id);

            $image->imageEdit($image, $content, $tag1, $tag2);

            DB::commit();
            return $this->redirectWithMessage("history", "success", "編集しました！");

        }catch(Exception $e){
            DB::rollback();
            return $this->redirectWithMessage("history", "danger", "エラー： {$e->getMessage()}");
        }
    }

    /**
     * 削除ページへ遷移
     */
    public function delete(Request $request){
        $user_id = Auth::user()->id;
        $img_id = $request->id;
        $image = new Image();
        $image = $image->imageSearchWithIdAndImageID($user_id, $img_id);
        
        return view("delete", compact("image"));
    }

    /**
     * 削除を実行
     */
    public function executeDelete(Request $request){
        $user_id = Auth::user()->id;
        $img_id = $request->id;

        DB::beginTransaction();
        try{
            $image = new Image();
            $image->imageDelete($user_id, $img_id);

            DB::commit();
            return $this->redirectWithMessage("history", "success", "削除しました！");

        }catch(Exception $e){

            DB::rollBack();
            return $this->redirectWithMessage("history", "danger", "エラー： {$e->getMessage()}");
        }
    }

    /**
     * 指定したリダイレクト先にメッセージを添付するメソッド
     */
    private function redirectWithMessage($redirect, $status, $message){
        $alert = [
            "status" => $status,
            "message" => $message,
        ];

        return redirect($redirect)->with("alert", $alert);
    }
}
