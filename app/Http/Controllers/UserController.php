<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;

class UserController extends Controller
{
    public function create(){
        return view("register");
    }
    public function store(UserRequest $request){
        // $this->validate($request,User::$rules);
        // フォームリクエストを使用
        // $form=$request->all();
        // パスワード=確認用パスワードが一致した場合。
        User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>$request->password,
        ]);
        return redirect("/login");
    }

    public function login_create(){
        return view("login");
    }
    public function login_store(LoginRequest $request){
        $this->validate($request,User);
        return view("login");

        // 変数にwhere等で入力した会員情報を探し取得する。
        // ifで入力内容とDBを比較する。
        // true=/に移行
        // false=「メール･パスワードが正しくない」とエラーメッセージを出し、/loginを再度開く。
    }
}
