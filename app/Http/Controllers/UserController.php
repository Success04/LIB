<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Swipe;
use App\Models\Chat;
use App\Events\SendMessage;
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
                return redirect()->route('users.index')->with('msg_success', 'マッチしました');
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
        $users = $auth->matches()->latest()->get();
        return view('users.matches', compact('users'));
    }

    //１人のマッチング相手の詳細ページ
    public function matches_show($num)
    {
        $auth = User::find(Auth::id());
        $match_users = $auth->matches()->latest()->get()->collect();
        $main_user = $match_users[$num];
        $count = $match_users->count();
        $prev = $num - 1 < 0 ? $num : $num - 1;
        $next = $num + 1 > $count - 1 ? $num : $num + 1;

        return view('users.matches_show', compact('match_users', 'main_user', 'prev', 'next', 'num'));
    }

    /**
     * マッチしたユーザーのルーム画面
     */
    public function room(User $user)
    {
        $is_match_user=$user->to_users()->where('from_user_id',Auth::id())->exists();
        if ($is_match_user) {
            $user = $user->loadCount('get_room_messages');
            return view('users.room', compact('user'));
        }
    }

    public function store_message(Request $request, User $user)
    {
        $message = e($request->message);
        $chat = Chat::create(['message' => $message, 'from_user_id' => Auth::id(), 'to_user_id' => $user->id]);
        broadcast(new SendMessage($chat))->toOthers();
        return 'success';
    }

    /**
     * messageを取得
     */
    public function get_messages(User $user)
    {
        $messages = $user->get_room_messages()->get();
        return $messages;
    }

    /**
     * プロフィール編集画面表示
     * @return View プロフィール編集画面
     */
    public function profileShow()
    {
        $user = Auth::user();
        return view('users.profile', ['user' => $user]);
    }

    /**
     * プロフィール編集機能（ユーザー名、メールアドレス）
     * @param Request $request
     * @return Redirect 一覧ページ-メッセージ（プロフィール更新完了）
     */
    public function profileUpdate(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255'/* , Rule::unique('users')->ignore(Auth::id()) */],
        ]);

        try {
            $user = Auth::user();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

        } catch (\Exception $e) {
            return back()->with('msg_danger', 'プロフィールの更新に失敗しました')->withInput();
        }

        return redirect()->route('users.index')->with('msg_success', 'プロフィールの更新が完了しました');
    }

    /**
     * パスワード編集機能
     * @param Request $request
     * @return Redirect 一覧ページ-メッセージ（パスワード更新完了）
     */
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user = Auth::user();
            $user->password = bcrypt($request->input('password'));
            $user->save();

        } catch (\Exception $e) {
            return back()->with('msg_danger', 'パスワードの更新に失敗しました')->withInput();
        }

        return redirect()->route('users.index')->with('msg_success', 'パスワードの更新が完了しました');
    }
}
