<!-- resources/views/teams.blade.php -->
@extends('layouts.app')
@section('content')
    <!-- Bootstrapの定形コード… -->
    <div class="card-body">
        <div class="card-title">
            投稿フォーム
        </div>
        <!-- バリデーションエラーの表示に使用-->
    	@include('common.errors')
        <!-- バリデーションエラーの表示に使用-->
        <!-- 投稿フォーム -->
        @if( Auth::check() )
        <form action="{{ url('teams') }}" method="POST" class="form-horizontal">
            {{ csrf_field() }}
            <!-- チーム名 -->
            <div class="form-group">
                チーム名
                <div class="col-sm-6">
                    <input type="text" name="team_name" class="form-control">
                </div>
            </div>
            <!--　登録ボタン -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </div>
        </form>
        @endif
    </div>
    <!-- 全てのチームリスト -->
    @if (count($teams) > 0)
       <div class="card-body">
           <div class="card-body">
               <table class="table table-striped task-table">
                   <!-- テーブルヘッダ -->
                   <thead>
                       <th>チーム一覧</th>
                       <th>オーナー</th>
                       <th>参加人数</th>
                       <th>詳細</th>
                       <th>参加</th>
                       <th>編集</th>
                   </thead>
                   <!-- テーブル本体 -->
                   <tbody>
                       @foreach ($teams as $team)
                           <tr>
                               <!-- チーム名 -->
                               <td class="table-text">
                                   <div>{{ $team->team_name }}</div>
                               </td>
                                <!-- チームオーナー -->
                               <td class="table-text">
                                   <div>{{ $team->user->name }}</div>    <!--Models/User.phpの関数user()を参照している-->
                               </td>
                               <!-- 所属人数 -->
                               <td class="table-text">
                                   <div>{{ $team->members()->count() }}</div>  <!--count()はLaravelの元からある関数-->
                               </td>
                               <!-- 詳細ボタン -->
                               <td class="table-text">
                                   <a href="{{ url('teams/'.$team->id) }}" class="btn btn-danger">詳細</a>
                               </td>
				                <!-- チーム参加ボタン -->
                               <td class="table-text">
                                   @if(Auth::check())
                                       @if(Auth::id() != $team->user_id && $team->members()->where('user_id',Auth::id())->exists() !== true)
                                           <form action="{{ url('team/'.$team->id) }}" method="GET">
                                            	{{ csrf_field() }}
                                            	<button type="submit" class="btn btn-danger">
                                            	参加
                                            	</button>
                                            </form>
                                        @endif
                                    @endif
                               </td>
                               <!-- チーム編集ボタン-->
                               <td class="table-text">
                                   @if(Auth::check()&& Auth::id() == $team->user_id )
                                    　　<form action="{{ url('teamedit/'.$team->id) }}" method="GET">
                                    	{{ csrf_field() }}
                                    	<button type="submit" class="btn btn-danger">
                                    	編集
                                    	</button>
                                    　　</form>	
                                    @endif
                                   
                               </td>
                           </tr>
                       @endforeach
                   </tbody>
               </table>
           </div>
       </div>		
   @endif
    
@endsection
