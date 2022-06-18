<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }
    //1.画像をcheckするバリデーションを追加する
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required','file','mimes:jpeg,png,jpg,bmb', 'max:1080'],
            'gender' => ['required', 'string', 'max:11'],
            'age' => ['required', 'string', 'max:11'],
            'intro' => ['required', 'text', 'max:255'],
        ]);
    }
    //2.画像をフォルダ(storage\app\public\images)に保存する。
    // 3.img_urlに取得先パスを作成する。
    // (本来的にはパスをデータベースに保存するのはセキュリティ上NG)
    // (名前を保存して取り出せるようにしておく)
    protected function create(array $data)
    {
        //リクエストから 画像のオリジナルネームを取得
        $fileName = $data['image']->getClientOriginalName();
        //画像をstoreAs()でサーバーに保存
        //storage\app\public\imagesの下に保存される。
        //Storage::putFileAs('public/images',$data['image'],$fileName);
        $data['image']->storeAs('public/images',$fileName);
        //保存した画像の取得パスを作成する。(publicパスからの相対パス)
        $fullFilePath = 'storage/images/'.$fileName;

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            //取得した画像リンクのパスをimg_urlに保存する。
            'img_url'  => $fullFilePath,
            'gender' => $data['gender'],
            'age' => $data['age'],
            'intro' => $data['intro'],
        ]);
    }
}
