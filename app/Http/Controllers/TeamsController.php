<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team; //この行を上に追加
use App\Models\User;//この行を上に追加
use Auth;//この行を上に追加
use Validator;//この行を上に追加



class TeamsController extends Controller
{
    //トップページ表示
    public function index()
    {
        //チームの情報全取得
        $teams = Team::get();

        return view( 'teams', ['teams'=>$teams] );
    }
    
    
    // //データ登録処理
    // public function store (Request $request){
        
    //     // バリデーション（入力チェック）
    //     $validator = Validator::make($request->all(),[
    //         'team_name' => 'required | max:255'
    //         ]);
        
    //     // バリデーションがエラーだったら
    //     if($validator->false() ){
    //         return redirect('/')
    //             ->withInput()  
    //             ->withErrors($validator);
    //     }
        
    //     //登録処理
    //     $teams = new Team;
    //     $teams->team_name = $request->team_name;
    //     $teams->user_id = Auth::id();
    //     $teams->save();
        
    //     return redirect('/');
    // }
    
    
    //登録メソッド
    public function store(Request $request)
    {
        // バリデーション（入力チェック）
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|max:255'
        ]);
        
        //バリデーションがエラーだったら
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()     //フォームで送られたデータを元に戻してあげる
                ->withErrors($validator);
        }
        
        //以下に登録処理を記述（Eloquentモデル）
        $teams = new Team;
        $teams->team_name = $request->team_name;
        $teams->user_id = Auth::id();//ここでログインしているユーザidを登録しています
        $teams->save();
        
        //チーム作成者もリレーションに登録する
        // $teams->members()->attach( Auth::user() );
        $teams->members()->attach( Auth::user(),['role'=>'owner'] );//<-ここが変わってるよ！！
        
        return redirect('/');
        
    }
    
    
    
    public function join($team_id)
    {
        // //ログイン中のユーザーを取得
        // $user = Auth::user();
        // //参加するチームを取得
        // $team = Team::find($team_id);
        // //リレーションの登録
        // $team->members()->attach($user);
        // return redirect('/');

        
        //ログイン中のユーザーを取得
        $user = Auth::user();
        //参加するチームを取得
        $team = Team::find($team_id);
        //リレーションの登録
        $team->members()->attach($user);
        
        return redirect('/');
    }
    
    

    //チーム編集画面表示
    public function edit (Team $team) {
                
           return view('teamsedit', ['team' => $team]);
                
        }




    //更新処理
    public function update (Request $request) {
        
         //バリデーション 
        $validator = Validator::make($request->all(), [
            'team_name' => 'required|max:255',
        ]);
        
        //バリデーション:エラー
        if ($validator->fails()) {
            return redirect('/')
                ->withInput()
                ->withErrors($validator);
        }
        
        //対象のチームを取得
        $team = Team::find($request->id);
        $team->team_name = $request->team_name;
        $team->save();
        
        return redirect('/');
        
        }

    //対象のデータ１つの詳細表示
    public function show(Team $team)
        {
            return view('teamsdetail',[
                'team'=> $team
                ]);
        }
    
}
