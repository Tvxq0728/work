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
  .footer{
    text-align:center;
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
            <h3>会員登録</h3>
          </td>
        </tr>
      <div content_input>
          <form action="/register" method="post">
          @csrf

          @error("name")
          <tr>
            <td class="error">{{$message}}</td>
          </tr>
          @enderror

          <tr>
            <td>
              <input type="name" name="name" placeholder="名前"
              value="{{old('name')}}">
            </td>
          </tr>

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
              <input type="text" name="password"
              placeholder="パスワード"
              value="{{old('password')}}">
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="password_check"
              placeholder="確認用パスワード">
            </td>
          </tr>

          @error("password_check")
          <tr>
            <td class="error">{{$message}}</td>
          </tr>
          @enderror


          <tr>
            <td>
              <input type="submit" value="会員登録" class="content_input-button">
            </td>
          </tr>
          <tr>
            <td>
              <p class="content_input-p">アカウントお持ちの方はこちら</p>
              <p class="content_input-p">
                <a href="/login" class="content_input-a">ログイン</a>
              </p>
            </td>
          </tr>
          </form>
        </div>
      </table>
    </div >
    <div class="footer">
      <footer>Atte.inc</footer>
    </div>
  </div {{--all--}}>

</body>
</html>
</body>
</html>