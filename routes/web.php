<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\StepsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function(){
    // プロフィール編集
    Route::get('/prof/edit', 'UsersController@edit')->name('prof.edit');
    Route::post('/prof', 'UsersController@update')->name('prof.update');
    // ステップ登録
    Route::get('/step/new', 'StepsController@new')->name('steps.new');
    Route::post('/step', 'StepsController@create')->name('steps.create');
    // ステップ編集
    Route::get('/step/{id}/edit', 'StepsController@edit')->name('steps.edit');
    Route::post('/step/{id}', 'StepsController@update')->name('steps.update');
    // チャレンジ
    Route::post('/challenge', 'challengesController@challenge');
    // クリア
    Route::post('/clear', 'ClearsController@clear');
    // マイページ
    Route::get('/mypage', 'StepsController@mypage')->name('step.mypage');
    // 削除
    Route::post('/step/{id}/delete', 'StepsController@destroy');

});

Auth::routes();
// TOPページ
Route::get('/index', 'StepsController@index')->name('step.index');

// ステップ一覧
Route::get('/step/list', 'StepsController@list')->name('step.list');
// ステップ詳細
Route::get('/step/{id}', 'StepsController@parentDetail')->name('step.parentDetail');
// 子ステップ詳細
Route::get('/step/{parent_id}/{child_id}', 'StepsController@childDetail')->name('child.Detail');
