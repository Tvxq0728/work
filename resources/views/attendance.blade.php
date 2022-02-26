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
  /* 日付 */
  .date_today{
    font-weight:bold;
    font-size:20px;
    text-align:center;
  }
  /* 表 */
  .content{
    background:#F5F5F5
  }
</style>

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

<div class="content">
  <div class="date">
    <form action="/">
      <input type="hidden" name="back" value="">
    </form>
    <p class="date_today">{{$today}}</p>
  </div>
  <div class="info">
    <table class ="info_attendance">
      <tr>
        <th>名前</th>
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤怠終了</th>
        <th>休憩時間</th>
        <th>勤怠時間</th>
      </tr>
      @php
      var_dump($attendance)
      @endphp

      @foreach($attendance as $attendance)
      <tr>
        <td>{{$attendance->user->name}}</td>
        <td>日付</td>
        <td>勤怠開始</td>
        <td>勤怠終了</td>
        <td>休憩時間</td>
        <td>勤怠時間</td>
      </tr>
      @endforeach
    </table>
  </div>
</div>