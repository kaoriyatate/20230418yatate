<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('css/reset.css')}}">
  <title>date</title>
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
    
    .square {
    border: 1px solid black;
    padding: 1px 8px;
    border-radius: 2px;
    background-color: white;

    }
    
    .d_title {
      text-align: center;
      padding-top:40px;

    }
    
    .d_item {
      text-decoration: none;
    }

    .list_item1 {
      width: 30px;
    }

    .list_item2 {
      padding-left: 150px;
    }
    .date {
      height: 150px;
    }
    .container {
      display: flex;
    }
    .date_list {
      width: 100%;
      border-collapse: collapse;
      
    }
    .p_item {
      text-align:center;
    }
    th {
      border-top: 1px solid black;
      line-height:60px;
    }
    td {
      border-top: 1px solid black;
      line-height:60px;
    }
    .list {
      border: none;
      cursor: pointer;
      background-color: transparent; 
    }
    p {
      text-align: center;
    }
    .pagination {
      display: flex;
      justify-content: center;
      margin-top:50px;
      
    }

    th {
    border-top: 1px solid black;
    line-height: 60px;
    text-align: center; 
    padding: 0 10px; 
  }

  td {
    border-top: 1px solid black;
    line-height: 60px;
    text-align: center; 
    padding: 0 10px; 
  }

  </style>

</head>
<body>
  <header>
    <h1>Atte</h1>
    <ul>
      <form action="{{ route('attendance.index') }}" method="GET">
       <li class="navi_item_1"><input class="list" type="submit" name="li_button" value="ホーム"></li>
      </form> 
      <li class="navi_item_2">日付一覧</li>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <li class="navi_item_3"><input class="logout" type="submit" name="log_button" value="ログアウト"></li>
      </form>  
    </ul> 
  </header>
  <main>
    <div class="date">
      <h2 class="d_title" id="date">
        <a class="d_item" href="{{ route('attendance.show', ['date' => $prevFormatted]) }}"><span class="square">&lt;</span>
        </a>
        {{ $date->format('Y-m-d') }}
        <a class="d_item" href="{{ route('attendance.show', ['date' => $nextFormatted]) }}"><span class="square">&gt;</span>
        </a>
      </h2>
    </div>
    <div class="container">
      <table class="date_list">
        <tr class="list_tag">
          <th class="list_item">名前</th>
          <th class="list_item">勤務開始</th>
          <th class="list_item">勤務終了</th>
          <th class="list_item">休憩時間</th>
          <th class="list_item">勤務時間</th>
        </tr>
        @foreach ($attendances as $attendance)
        @if ($attendance->attendance_date == $date->format('Y-m-d'))
        <tr>
          <td class="p_item">{{ $attendance->user->name }}</td>
          <td class="p_item">{{ $attendance->start_time }}</td>
          <td class="p_item">{{ $attendance->end_time }}</td>    
          <td class="p_item">{{ $attendance->total_break_duration }}</td>
          <td class="p_item">{{ $attendance->total_work_duration }} </td>
        </tr>
        @endif
        @endforeach
      </table>  
    </div>
    <div class="pagination justify-content-center">
      {{ $attendances->links('vendor.pagination.bootstrap-4') }}
      </div>
  </main>
  <footer>
    <p>Atte,inc.</p>  
  </footer>   
</body>
</html>