<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    //プロフィール編集画面表示
    public function edit()
    {
        return view('step.profEdit');
    }

    //　プロフィール編集
    public function update(Request $request)
    {   //　ユーザーのレコード取得
        $user = User::find(Auth::user()->id);

        //　バリデーション(画像以外)
        $request->validate([
            'name' => 'required|string|max:20',
            'email' => 'required|email',
            'intro' => 'string|max:191|nullable',
        ]);
        //　画像以外のデータ更新
        $userData = array(
            'name' => $request->name,
            'email' => $request->email,
            'intro' => $request->intro,
        );
        
        //　画像の更新があればバリデーションしてアップロードし、DB更新データに格納
        if(!empty($request->img)){
            $request->validate([
                'img' => 'image|max:500'
            ]);
            //　アップロード
            $post = $request->img;
            $path = Storage::disk('s3')->put('/', $post, 'public');
            $img = $path;

            //　更新データに格納
            $userData += array('img' => $img);
        }

        //　DB更新
        $user->fill($userData)->save();
        session()->flash('flash_message','プロフィールを編集しました');
        return response()->json(['flg'=> true]);
    }
}
