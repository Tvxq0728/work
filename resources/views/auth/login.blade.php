{{--<style>
    .login_button{
        text-align:center;
    }
</style>
<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <!-- <x-label for="email" :value="__('Email')" /> -->

                <x-input id="email" class="block mt-1 w-full" type="email" name="email"
                placeholder="メールアドレス"
                :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <!-- <x-label for="password" :value="__('Password')" /> -->

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required
                                placeholder="パスワード"
                                autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <!-- <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <!-- @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                        {{ __("アカウントをお持ちでない方はこちら") }}
                    </a>
                @endif -->

            </div>
            <div class="login_button">
                <x-button class="">
                    {{ __('ログイン') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>--}}


<!-- 下記が反映 -->
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<style>
  body{
    height:100%;
  }
  .content{
    background:#F5F5F5
  }
  table{
    text-align:center;
    margin:0 auto;
    width:100%;
  }
  td{
    padding:5px;
  }
  .content_input-p{
    margin:0;
  }
  .content_input-p:first-child{
    color:Silver;
    font-size:10px;
  }
  .content_input-a{
    margin:0;
    color:blue;
    text-decoration:none;
  }
  input{
    width:30%;
  }
  .content_input-button{
    width:30%;
    color:white;
    background:blue;
    padding:5px;
    border:none;
    border-radius:2px;
    cursor:pointer;
  }
  .content_input-button:hover{
    color:AliceBlue;
    background:#00008B;
  }
  .content_input-a:hover{
    color:#00008B;
  }

  .error{
    font-size:5px;
    color:red;
  }
</style>
<body>
  <div class="all">
    <div class="header">
      <header><h1>Atte</h1></header>
    </div>
    <div class="content">
      <table>
        <tr>
          <td>
            <h3>ログイン</h3>
          </td>
        </tr>
      <div content_input>
          <form action="/login" method="post">
          @csrf
          @error("email")
          <tr>
            <td class="error">{{$message}}</td>
          </tr>
          @enderror
          <tr>
            <td>
              <input type="email" name="email" placeholder="メールアドレス"
              value="{{old('email')}}">
            </td>
          </tr>
          @error("password")
          <tr>
            <td class="error">{{$message}}</td>
          </tr>
          @enderror
          <tr>
            <td>
              <input type="password" name="password"
              placeholder="パスワード">
            </td>
          </tr>
          <tr>
            <td>
              <input type="submit" value="ログイン" class="content_input-button">
            </td>
          </tr>
          <tr>
            <td>
              <p class="content_input-p">アカウントをお持ちでない方はこちら</p>
              <p class="content_input-p">
                <a href="/register" class="content_input-a">会員登録</a>
              </p>
            </td>
          </tr>
          </form>
        </div>
      </table>
    </div >
  </div {{--all--}}>

  <footer>Atte.inc</footer>
</body>
</html>
