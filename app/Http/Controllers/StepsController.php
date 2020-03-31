<?php

namespace App\Http\Controllers;

use App\User;
use App\Category;
use App\Challenge;
use App\Step;
use App\ChildStep;
use App\Clear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Psy\debug;

class StepsController extends Controller
{
    // TOP画面表示
    public function index()
    {   
        $parentSteps = Step::select('id', 'title', 'img', 'category_id', 'time')->with('childSteps:step_id,id')->with('category:id,name')->get();
        $categories = Category::all();
        return view('step.index', compact('parentSteps', 'categories'));
    }
    // ステップ新規登録画面表示
    public function new()
    {   
        $categories = Category::all();
        $editFlg = 0;
        return view('step.stepRegister', compact('categories','editFlg'));
    }

    //ステップ新規登録処理
    public function create(Request $request)
    {   
        //バリデーション
        $request->validate([
            'parent_title' => 'required|string|max:20',
            'parent_category' => 'required|integer',
            'parent_content' => 'required|string|max:191',
            'child_title.*' => 'required|string|max:20',
            'child_time.*' => 'required|integer',
            'child_content.*' => 'required|string|max:191'
        ]);
        //親ステップ登録
        $step = new Step;
        $stepsData = array(
            'title' => $request->input('parent_title'),
            'category_id' => $request->input('parent_category'),
            'content' => $request->input('parent_content'),
            'time' => $request->input('parent_time')
        );
        if(!empty($request->parent_img)){
            $request->validate([
                'parent_img' => 'image|max:500'
            ]);
            //　アップロード
            $path = $request->parent_img->store('public/img');
            $img = basename($path);

            //　更新データに格納
            $stepsData += array('img' => $img);
        }
        
        Auth::user()->steps()->save($step->fill($stepsData));

        //子ステップ登録
        
        $sum = $request->input('sum'); //子ステップデータ数
        
        for($i = 0; $i < $sum; $i++){
            
            $childStepsData = array(
                'title' => $request->child_title[$i],
                'time' => $request->child_time[$i],
                'content' => $request->child_content[$i],
                'num' => $i + 1,
            );
            $childStep = new ChildStep;
            $step->childSteps()->save($childStep->fill($childStepsData));
        }
        
        $step->childSteps()->save($childStep->fill($childStepsData));
        session()->flash('flash_message','STEPを登録しました');
        return response()->json(['flg'=> true]);
    }

    // ステップ編集画面表示
    public function edit($id)
    {   
        //GETパラメータが数字かどうかチェック
        if(!ctype_digit($id)){
            return redirect('/home')->with('flash_message', '無効な操作が行われました。');
        }
        //認証されているユーザーID取得
        $user_id = Auth::id();
        
        //親STEPデータ取得
        $parentStep = Step::where('user_id', $user_id)->where('id',$id)->select(['id','img','title','category_id','content'])->get();

        //子STEPデータ取得
        $childSteps = ChildStep::where('step_id', $id)->select(['id', 'title', 'time', 'content', 'num'])->get();

        //カテゴリーデータ取得
        $categories = Category::all();

        //編集フラグを立てる
        $editFlg = 1;

        return view('step.stepRegister', compact('parentStep', 'childSteps', 'categories', 'editFlg'));
    }
    // ステップ編集
    public function update(request $request, $id)
    {   
        //GETパラメータが数字かどうかチェック
        if(!ctype_digit($id)){
            return redirect('/home')->with('flash_message', '無効な操作が行われました。');
        }
        //バリデーション
        $request->validate([
            'parent_title' => 'required|string|max:20',
            'parent_category' => 'required|integer',
            'parent_content' => 'required|string|max:191',
            'child_title.*' => 'required|string|max:20',
            'child_time.*' => 'required|integer',
            'child_content.*' => 'required|string|max:191'
        ]);
        //親ステップの更新するレコードを取得
        $step = Step::find($id);
        //親ステップ編集
        $stepsData = array(
            'title' => $request->input('parent_title'),
            'category_id' => $request->input('parent_category'),
            'content' => $request->input('parent_content'),
            'time' => $request->input('parent_time'),
        );
        if(!empty($request->parent_img)){
            $request->validate([
                'parent_img' => 'image|max:500'
            ]);
            //　アップロード
            $path = $request->parent_img->store('public/img');
            $img = basename($path);

            //　更新データに格納
            $stepsData += array('img' => $img);  
        }
        Auth::user()->steps()->save($step->fill($stepsData));

        // 子ステップ編集
          // 更新するレコードを取得
        $childStepRecode = $step->childSteps;
        $sum = $request->input('sum'); //子ステップデータ数
        
        for($i = 0; $i < $sum; $i++){
            
            $childStepsData = array(
                'title' => $request->child_title[$i],
                'time' => $request->child_time[$i],
                'content' => $request->child_content[$i],
                'num' => $i + 1,
            );
            if(!empty($childStepRecode[$i])){
                $childStep = $childStepRecode[$i];
                $childStep->fill($childStepsData)->save();
            }else{
                $childStep = new ChildStep;
                $step->childSteps()->save($childStep->fill($childStepsData));
            }
            
        }
        session()->flash('flash_message','STEPを編集しました');
        return response()->json(['flg'=> true]);
        
    }

    // ステップ一覧表示
    public function list(){
        //ステップ一覧表示に必要な親ステップデータとそれに紐づく子ステップ,カテゴリーを合わせて取得
        $parentSteps = Step::select('id', 'title', 'img', 'category_id', 'time')->with('childSteps:step_id,id')->with('category:id,name')->get();
        $categories = Category::all();
        return view('step.stepList', compact('parentSteps', 'categories'));
    }  
    
    // 親ステップ詳細画面表示
    public function parentDetail($id)
    {
        if(!ctype_digit($id)){
            return redirect('/home')->with('flash_message', '無効な操作が行われました。');
        }
        //GETパラメータから対象のレコードを取得
        $step = Step::find($id);
        
        $parentStep = Step::where('id',$id)->with('category:id,name')->first();
        $childSteps = $step->childSteps()->get();
        $userProf = $step->user()->first();
        // 認証済みユーザーか判定してフラグを立てる
        if(Auth::check()){
            $authFlg = 1;
        }else{
            $authFlg = 0;
        }
        // 認証済みユーザーで、かつチャレンジ中だったらフラグを立てる
        if($authFlg && Challenge::where('step_id', $id)->exists()){
            $challengeFlg = 1;
        }
        else{
            $challengeFlg = 0;
        }
        return view('step.parentDetail', compact('parentStep','childSteps','userProf', 'authFlg', 'challengeFlg'));
    }

    // 子ステップ詳細画面表示
    public function childDetail($parent_id, $child_id)
    {   
        if(!ctype_digit($parent_id) || !ctype_digit($child_id)){
            return redirect('/home')->with('flash_message', '無効な操作が行われました。');
        }
        $step = Step::find($parent_id);
        
        $parentStep = Step::where('id',$parent_id)->with('category:id,name')->first();
        $childSteps = $step->childSteps()->get();
        $userProf = $step->user()->first();
        $childStepDetail = ChildStep::where('id',$child_id)->first();
        // 認証済みユーザーか判定しフラグを立てる
        if(Auth::check()){
            $authFlg = 1;
        }else{
            $authFlg = 0;
        }
        // 認証済みで、かつチャレンジ中だったらフラグを立てる
        if($authFlg && Challenge::where('step_id', $parent_id)->exists()){
            $challengeFlg = 1;
        }
        else{
            $challengeFlg = 0;
        }
        // チャレンジ済みで、かつクリア済みだったらフラグを立てる
        if($challengeFlg && Clear::where('child_step_id', $child_id)->exists()){
            $clearFlg = 1;
        }else{
            $clearFlg = 0;
        }
        return view('step.childDetail', compact('parentStep','childSteps','userProf', 'childStepDetail', 'authFlg', 'challengeFlg', 'clearFlg'));
    }

    // マイページ表示
    public function mypage()
    {   
        // 認証されているユーザーのチャレンジ登録しているステップIDを配列に格納
        $challenge_id = Auth::user()->challenges()->pluck('step_id')->toArray();

        // 配列に格納したステップIDに該当するステップのレコードを取得(クリア情報等合わせて取得)
        $challengeSteps = Step::whereIn('id',$challenge_id)->with(['childSteps:step_id,id','childSteps.clears','category:id,name'])->get();
        // ユーザーが登録したステップ情報を取得
        $registSteps = Auth::user()->steps()->with('childSteps:step_id,id')->with('category:id,name')->get();

        return view('step.mypage', compact('challengeSteps', 'registSteps'));
    }

    // 登録したステップの削除
    public function destroy($id)
    {   
        if(!ctype_digit($id)){
            return redirect('/mypage')->with('flash_message', '無効な操作が行われました。');
        }
        // 親ステップIDから紐づくClearDBのレコードを検索して削除
        $child_step_id = Step::find($id)->childSteps()->pluck('id')->toArray();
        Clear::whereIn('child_step_id',$child_step_id)->delete();
        // 該当するChallengeDBのレコードを削除
        Challenge::where('step_id',$id)->delete();
        // 該当する子ステップを削除
        ChildStep::where('step_id',$id)->delete();
        // 親ステップ削除
        Step::find($id)->delete();
    }
}
