<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <style>
/* 全て */
  *{
    color:black;
  }
  body{

  }
/* ヘッダー */
  .header{
    display:flex;
    justify-content:space-between;
    align-items:center;
  }
  .header_nav{
    width:40%;
  }
  .header_nav ul{
    display:flex;
    justify-content:space-around;
  }
  .header_nav ul li{
    list-style:none;
  }
  .header_nav ul li a:hover{
    color:red;
  }
  .header_nav a{
    text-decoration:none;
  }
  /* ユーザータイトル */
  .user_list-title{
    font-weight:bold;
    text-align:center;
    padding-top:30px;
  }

/* 打刻 */
  .content{
    background:#F5F5F5
  }
  .content_stampbtn{
    display:flex;
    justify-content:space-around;
    padding:20px 0;
  }
  .content button{
    border:none;
    padding:60px 120px;
    background:white;
    font-weight:bold;
  }
  .btn_disabled{
    border-color:red;
    border-radius:10px;
  }


/* フッター */
  .footer{
    text-align:center;
  }
</style>
<body>
<!-- ヘッダー -->
    <div class="header">
      <div class="header_title">
        <header><h1>Atte</h1></header>
      </div>
      <div class="header_nav">
          <ul>
            <li><a href="/">ホーム</a></li>
            <li><a href="/attendance">日付一覧表</a></li>

            <!-- ↓welcome.blade/navgation.blade参照 -->
            <form action="{{route('logout')}}" method="POST">
              @csrf
            <li> <x-dropdown-link :href="route('logout')"
              onclick="event.preventDefault();
              this.closest('form').submit();">
                                {{ __('ログアウト') }}
                            </x-dropdown-link></li>
          </form>
          </ul>
      </div>
    </div>
<!-- 打刻 -->
  <div class="content">
    <div class="user_list">
      <p class="user_list-title">{{$user->name}}さんお疲れ様です。</p>
    </div>
    <div class="session">
      <p>
        {{session('message')}}
      </p>
      終了
      <p>
        {{session('end_at')}}
      </p>
      開始
      <p>
        {{session('start_at')}}
      </p>
      差分
      <p>
        {{session("work_total")}}
      </p>
      勤怠時間
      <p>
        {{session('work_at')}}
      </p>
    </div>

    <div class="content_stampbtn" id="btn_start">
      <form action="/stamp/start" method="POST">
        {{--勤怠開始--}}
        @if(Session::has("start"))
          @csrf
            <button type="submit" class="btn_disabled" id="btn_start" disabled>
              勤怠開始
            </button>
        @else
        @csrf
            <button type="submit" class="btn" id="btn_start">
              勤怠開始
            </button>
        @endif
        </form>
        <form action="/stamp/end" method="POST">
        {{--勤怠終了--}}
        @if(Session::has("end"))
          @csrf
            <button type="submit" class="btn_disabled" id="btn_start" disabled>
              勤怠終了
            </button>
          @else
            @csrf
            <button type="submit" class="btn" id="btn_start">
              勤怠終了
            </button>
          @endif
        </form>
      </div>
    <div class="content_stampbtn" id="btn_start">
      <form action="/rest/start" method="POST">
      {{--休憩開始--}}
        @if(Session("rest_start"))
          @csrf
            <button type="submit" class="btn_disabled" id="btn_start" disabled>
              休憩開始
            </button>
          @else
          @csrf
            <button type="submit" class="btn" id="btn_start">
              休憩開始
            </button>
          @endif
        </form>
        <form action="/rest/end" method="POST">
        @if(Session("rest_end"))
        {{--休憩終了--}}
          @csrf
            <button type="submit" class="btn_disabled" id="btn_start" disabled>
              休憩終了
            </button>
          @else
          @csrf
          <button type="submit" class="btn" id="btn_start">
              休憩終了
          </button>
          @endif
        </form>
      </div>
  </div>


<!-- フッター -->
    <div class="footer">
      <footer>Atte.inc</footer>
    </div>

</body>
</html>
</body>
</html>