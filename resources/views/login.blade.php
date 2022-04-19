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
              <input type="email" name="mail" placeholder="メールアドレｓ"
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