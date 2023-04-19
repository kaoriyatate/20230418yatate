<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/reset.css')}}">
    <title>{{ config('app.name', 'Laravel') }}</title>


    <style>
      h1 {
        margin-left: 50px;
        }
      
      main {
        max-width: 100%;
        background-color: #f5f5f5;
        height: 690px;
      }

      h2 {
        text-align: center;
        padding-top: 80px;
      }
      
      .form-control {
        width: 400px;
        height: 40px;
        margin-top: 20px;
        
      }

      .f_item {
        max-width: 400px;
        margin: 0px auto;
      }
      
      .login {
        width: 410px;
        height: 40px;
        margin-top: 20px;
        background-color: blue;
        color: white;
      }
       
      .more {
        text-align: center;
        color: gray;
        padding-top: 20px;
      }

      .newuser {
        text-decoration:none;
        color: blue;
        
      }

      .link {
         text-align:center;
         margin-top: -40px;
         font-weight: bold;
      }
      
      p {
      text-align: center;
    }

    </style>    
  </head>
  <body>
    <header>    
      <h1>Atte</h1>
    </header> 
    <main> 
      <h2>ログイン</h2>
      <form action="{{ route('login') }}" method="POST">
      @csrf
        <div class ="f_item">  
        <input id="email" type="email" class="form-control" placeholder="メールアドレス" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class ="f_item">  
          <input id="password" type="password" class="form-control" placeholder="パスワード" name="password" required>
        </div>
        <div class ="f_item">  
          <button type="submit" class="login" name="login" >ログイン</button>
        </div>
        <p class ="more">アカウントをお持ちでない方はこちらから</p><br>
        <div class ="link">
          <a class="newuser" href="{{ route('register') }}">会員登録</a>
        </div>
      </form>          
    </main>
    <footer>
      <p>Atte,inc.</p>  
    </footer>
  </body>
</html>
