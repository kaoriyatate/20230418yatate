<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('css/reset.css')}}">
  <title>stamp</title>
  <style>
    header {
      max-width: 100%;
      
    }
    ul {
  
      display:flex;
      justify-content: flex-end;
      margin-right:50px;
      margin-top:-50px;
      
      
    }
    li {
      list-style:none;
      margin-left:50px;
      
    }
    main {
      max-width: 100%;
      background-color: #f5f5f5;
      height: 720px;
    }
    .g_item {
      text-align:center;
      padding-top:50px;
      font-weight: bold;

    }

    .list {
      border: none;
      cursor: pointer;
      background-color: transparent; 
    }
    .logout {
      border: none;
      cursor: pointer;
      background-color: transparent;
    }
    .work_box {
      display: flex;
      flex-direction:row;
      max-width: 100%;
      flex-wrap: wrap;
      justify-content:center;
      


    }
    .work_item {
      background-color: white;
      width: 40%;
      height: 200px;
      margin: 20px;
      

    
    }
    .work_t {
      border: none;
      cursor: pointer;
      background-color: white;
      padding: 100px 0px 0px 250px;
      font-weight: bold;
      font-size: 16px;
  
    }
    p {
      text-align: center;
    }
    .alert {
      text-align:center;
    }
    
    
    
    

    






  </style>
</head>
<body>
  <header>
    <h1>Atte</h1>
    <ul>
      <li class="navi_item_1">ホーム</li>
      <form action="{{ route('attendance.show',['id' => $attendance->id, 'date' => $date]) }}" method="GET">
       <li class="navi_item_2"><input class="list" type="submit" name="li_button" value="日付一覧"></li>
      </form> 
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <li class="navi_item_3"><input class="logout" type="submit" name="log_button" value="ログアウト"></li>
      </form>  
    </ul> 
  </header>
  <main>
    @if(Auth::check())
    <p class="g_item">{{Auth::user()->name}}さんお疲れ様です！</p>
    @endif
    <div class="work_box">
      <div class="work_item">
        <form method="POST" action="{{ route('attendance.store') }}">
        @csrf
          <button type="submit" class="work_t" name="start" value="1">勤務開始</button>
          <input type="hidden" name="attendance_date" value="{{ date('Y-m-d') }}">
          <input type="hidden" name="start_time" value="{{ date('H:i:s') }}">
        </form>  
      </div>
      <div class="work_item">
        <form method="POST" action="{{ route('attendance.update', $attendance->id) }}"> 
        @method('PUT')
        @csrf 
          <button type="submit" class="work_t" name="end" value="1">勤務終了</button>
          <input type="hidden" name="attendance_date" value="{{ date('Y-m-d') }}">
          <input type="hidden" name="end_time" value="{{ date('H:i:s') }}">
        </form>  
      </div>
      <div class="work_item">
        <form method="POST" action="{{ route('break_time.store') }}"> 
        @csrf
         @php
            $attendance = App\Models\Attendance::latest('id')->first();
         @endphp
          <input type="hidden" name="attendance_id" value="{{ $attendance->id }}"> 
          <button type="submit" class="work_t" name="break_start" value="1">休憩開始</button>
          <input type="hidden" name="break_start_time" value="{{ date('Y/m/d H:i:s') }}">
        </form>  
      </div>
      <div class="work_item">
        <form method="POST" action="{{ route('break_time.update') }}">
        @csrf 
        @method("PUT") 
          <button type="submit" class="work_t" name="break_end" value="1">休憩終了</button>
          <input type="hidden" name="break_end_time" value="{{ date('Y/m/d H:i:s') }}"> 
        </form>  
      </div>
    </div>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    @if (session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif 
  </main>
  <footer>
    <p>Atte,inc.</p>  
  </footer>

  
</body>
</html>