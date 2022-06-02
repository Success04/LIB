<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     *  ●index()メソッドを作成する
     *       1.ユーザーを取得してメイン画面を表示させる。
     *       2.ユーザーは自分以外と、未選択のユーザーのみ取得する。
     */
    public function index()
    {
        //ログインユーザーの取得
        $auth = User::find(Auth::id());
        //ログインユーザーがすでに選択したユーザー達のidを配列で取得
        //to_user_id一覧が取得できる。
        $swipedUserIds = $auth->from_users()->get()->pluck('id');
        //idsには含まれていないusersを取得して、その一番最初のuserを取得
        $user = User::where('id', '<>', $auth->id)->whereNotIn('id', $swipedUserIds)->first();
        return view('users.index', compact('user'));
    }

    /**
     *  ●store()メソッドを作成する
     *       1.好きボタンを押して、かつ、相手のis_likeの状態もtrueなら、
     *         マッチしましたというフラッシュメッセージ付きで
     *         route('users.index')にリダイレクトする。
     *       2.falseなら、そのまま、route('users.index')にリダイレクトする。
     *       結果index()で未選択のユーザーが取得されindex.blade.phpで表示されます。
     */
    public function store(Request $request, User $user)
    {

        $swipes = $user->from_users();
        //多対多におけるupdateOrCreate()の変わり。
        $swipes->syncWithoutDetaching([$request->except('_token')]);
        $is_like_auth = $swipes->wherePivot('to_user_id', Auth::id())->wherePivot('is_like', true)->exists();
        //authが好きなら
        if ($request->is_like) {
            //その相手のユーザーのis_likeもtrueなら
            if ($is_like_auth) {
                //true同士なら、フラッシュメッセージをつけてメイン画面にリターン
                return redirect()->route('users.index')->with('flash_message', 'マッチしました');
            }
        }
        //falseなら、そのままメイン画面にリターン
        return redirect()->route('users.index');
    }

    /**
     *マッチした画面一覧へ
     */
    public function matches()
    {
        $auth = User::find(Auth::id());
        //matches()はリレーションのメソッドです。
        $users = $auth->matches()->orderBy('id','asc')->get();
        return view('users.matches', compact('users'));
    }

    //１人のマッチング相手の詳細ページ
    
    public function matches_show($num)
    {
        $auth = User::find(Auth::id());
        $match_users = $auth->matches()->orderBy('id', 'asc')->get()->collect();
        $main_user = $match_users[$num];
        $count = $match_users->count();
        $prev = $num - 1 < 0 ? $num : $num - 1;
        $next = $num + 1 > $count - 1 ? $num : $num + 1;

        return view('users.matches_show', compact('match_users', 'main_user', 'prev', 'next', 'num'));
    }
}
