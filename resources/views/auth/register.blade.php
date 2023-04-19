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
      <h2>会員登録</h2>
      <form action="{{ route('register') }}" method="POST">
      @csrf
        <div class ="f_item">  
          <input id="name" type="text" class="form-control @error('name') is invalid @enderror" placeholder="  名前" name="name" value="{{ old('name') }}" required autofocus>
          @error('name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ messsage }}</strong>
          </span>
          @enderror  
        </div>
        <div class ="f_item">  
          <input id="email" type="email" class="form-control @error('email') is invalid @enderror" placeholder="  メールアドレス" name="email" value="{{ old('email') }}" required autofocus>
          @error('email')
          <span class="invalid-feedback" role="alert">
            <strong>{{ messsage }}</strong>
          </span>
          @enderror  
        </div>
        <div class ="f_item">  
          <input id="password" type="password" class="form-control @error('password') is invalid @enderror" placeholder="  パスワード" name="password" required autocomplete="new-password">
          @error('password')
          <span class="invalid-feedback" role="alert">
            <strong>{{ messsage }}</strong>
          </span> 
          @enderror 
        </div>
        <div class ="f_item">  
          <input id="password-confirm" type="password" class="form-control" placeholder="  確認用パスワード" name="password_confirmation" required autocomplete="new-password">
        </div>
        <div class ="f_item">  
          <button type="submit" class="login" name="login" >会員登録</button>
        </div>
        <p class ="more">アカウントをお持ちの方はこちらから</p><br>
        <div class ="link">
          <a class="newuser" href="{{ route('login') }}">ログイン</a>
        </div>
      </form>            
    </main>
    <footer>
      <p>Atte,inc.</p>  
    </footer>
  </body>
</html>

