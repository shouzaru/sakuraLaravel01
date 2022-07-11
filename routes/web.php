<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamsController;//追記

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TeamsController::class, 'index']);

Route::post('teams', [TeamsController::class, 'store']);
// Route::post('teams', 'TeamsController@store');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('team/{team_id}', [TeamsController::class, 'join']);

Route::get('teamedit/{team}', [TeamsController::class, 'edit']); 

//チーム更新処理
Route::post('teams/update',  [TeamsController::class, 'update']);

// 対象のチーム1件の詳細表示
Route::get('teams/{team}', [TeamsController::class, 'show']);


