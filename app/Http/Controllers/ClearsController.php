<?php

namespace App\Http\Controllers;

use App\ChildStep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Challenge;
use App\Clear;
use Illuminate\Support\Facades\Auth;

class ClearsController extends Controller
{
    public function clear(Request $request)
    {
        $child_id = $request->child_id;
        Log::debug($child_id);

        //　クリアが押された子ステップのレコード取得
        $childStep = ChildStep::find($child_id);

        //該当するチャレンジのレコード取得
        $challenge = Challenge::where('user_id', Auth::user()->id)->where('step_id', $childStep->step_id)->first();
        
        $data = array(
            'challenge_id' => $challenge->id,
            'child_step_id' => $child_id
        );
        $clear = new Clear;
        $clear->fill($data)->save();
    }
}
