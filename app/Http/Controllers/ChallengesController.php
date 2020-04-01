<?php

namespace App\Http\Controllers;

use App\Challenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChallengesController extends Controller
{
    public function challenge(Request $request)
    {
        Log::debug($request->all());
        $challenge = new Challenge;
        Auth::user()->challenges->save($challenge->fill($request->all()));

        return response()->json(['flg'=> true]);
    }
}
