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
    height:100%;
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
/* 打刻 */
  .content{
    background:#F5F5F5
  }
  .content_comment{
    display:flex;
    justify-content:center;
  }
  .content_button-ul{
    display:flex;
    justify-content:space-around;
    list-style:none;
  }
  .content_button-ul li{
    width:30%;
    text-align:center;
    font-weight:bold;
    background-color:white;
    padding:2rem 3rem;
    margin-bottom:20px;
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
    <div class="session">
      <p>
        {{session('message')}}
      </p>
    </div>
    <ul class="btn-list">
      <li class="stampbtn" id="btn_start">
        <form action="/stamp/start" method="POST">
          @csrf
            <button type="submit" class="btn" id="btn_start">
              勤怠開始
            </button>
        </form>
      </li>
    </ul>

  </div>


<!-- フッター -->
    <div class="footer">
      <footer>Atte.inc</footer>
    </div>

</body>
</html>
</body>
</html>