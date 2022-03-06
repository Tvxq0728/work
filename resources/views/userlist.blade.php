<style>
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
  /* 表 */
  .content{
    background:#F5F5F5
  }
  .user{
    display:flex;
    justify-content:center;
  }
    .info_list{
    width:100%;
    margin:0 auto;
  }
  table{
    text-align:center;
  }
  </style>
  <body>
    <div class="header">
      <div class="header_title">
        <header><h1>Atte</h1></header>
      </div>
      <div class="header_nav">
          <ul>
            <li><a href="/">ホーム</a></li>
            <li><a href="/attendance">日付一覧表</a></li>
            <li><a href="/userlist">勤怠一覧表</a></li>
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

    <div class="content">
      <div class="user">
        User
      </div>
      <div class="list">
        <table class="info_list">
          <tr>
            <th>日付</th>
            <th>勤怠開始</th>
            <th>勤怠終了</th>
            <th>休憩時間</th>
            <th>勤怠時間</th>
          </tr>
          <tr>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
          </tr>
        </table>
      </div>
    </div>
    @php
      echo $stamp;
    @endphp
  </body>