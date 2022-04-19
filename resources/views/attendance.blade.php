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
    color: black;
  }
  .header_nav ul li{
    list-style:none;
  }
  .header_nav ul li a:hover{
    color:red;
  }
  .header_nav a{
    text-decoration:none;
    color: black;
  }
  /* 日付 */
  .date{
    display:flex;
    justify-content:center;
  }
  .date_today{
    font-weight:bold;
    font-size:30px;
    text-align:center;
    margin:0;
  }
  .date_button{
    margin:0;
    font-size:30px;
    background:white;
    border-color:blue;
    color:blue;
    cursor:pointer;
  }
  /* 表 */
  .content{
    background:#F5F5F5
  }
  .info_attendance{
    width:100%;
    margin:0 auto;
  }
  table{
    text-align:center;
  }
  svg.w-5.h-5 {
    width: 30px;
    height: 30px;
    }
/* ページネーション */
  .pagination {
    display:flex;
    justify-content:center;
    list-style:none;
  }
  .pagination li {
    background:white;
    width:30px;
    text-align:center;
    margin-bottom:2px;
    margin-right:1px;
  }
  .pagination li:hover{
    background: blue;
    color: white;
  }
  .page-item :hover{
    background: blue;
    color: white;
  }
  .pagination li a {
    display:block;
    height: 100%;
    text-decoration:none;
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
    <form action="/attendance" method="POST">
      @csrf
      <input type="hidden" name="back" value="back">
      <input type="hidden" name="date" value={{$today}}>
      <button class="date_button"><</button>
    </form>
    <p class="date_today">{{$today}}</p>
    <form action="/attendance" method="POST">
      @csrf
      <input type="hidden" name="next" value="next">
      <input type="hidden" name="date" value={{$today}}>
      <button class="date_button">></button>
    </form>
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
      @foreach($stamps as $stamp)
      <tr>
        <td>{{$stamp->user->name}}</td>
        <td>{{$stamp->date->format("Y-m-d")}}</td>
        <td>{{$stamp->start_at->format("H:i:s")}}</td>
        <td>{{$stamp->end_at}}</td>
        <td>
          {{$stamp->rest->total_at->format("H:i:s")}}
        </td>
        <td>{{$stamp->work_at}}</td>
      </tr>
      @endforeach
    </table>
    <div>
      {{$stamps->appends(['date' => $today ])
        ->links()}}
    </div>
  </div>
</div>
