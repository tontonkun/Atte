@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/time_record.css') }}">
@endsection

@section('headerLinks')
<div class="headerLinks">
    <form class="form" action="/" method="GET">
        @csrf
        <button class="header-nav__button">ホーム</button>
    </form>
    <form class="form" action="/time_record" method="GET">
        @csrf
        <button class="header-nav__button">勤怠一覧</button>
    </form>
    <form class="form" action="/user_list" method="GET">
        @csrf
        <button class="header-nav__button">ユーザー一覧</button>
    </form>
    <form class="form" action="{{ route('logout') }}" method="POST">
        @csrf
        <button class="header-nav__button">ログアウト</button>
    </form>
</div>
@endsection

@section('content')

<div class="titleArea">
    <!-- 昨日の勤務情報へ移動 -->
    <form action="/time_record_yesterday" method="GET">
        @csrf
        <input type="hidden" name="date" value="{{ $work_date }}">
        <button class="yesterday">＜</button>
    </form>

    <div class="title">勤怠一覧 - {{ $work_date }}</div>

    <!-- 明日の勤務情報へ移動 -->
    <form action="/time_record_tomorrow" method="GET">
        @csrf
        <input type="hidden" name="date" value="{{ $work_date }}">
        <button class="tomorrow">＞</button>
    </form>
</div>

<table class="timeRecord">
    <tr>
        <th>Work ID</th>
        <th>ユーザー名</th>
        <th>日付</th>
        <th>勤務開始</th>
        <th>勤務終了</th>
        <th>休憩時間</th>
        <th>勤務時間</th>
    </tr>

    @foreach ($works as $work)
        <tr>
            <td>{{ $work->id }}</td>
            <td>{{ $work->user->name }}</td>
            <td>{{ $work->work_date }}</td>
            <td>{{ $work->start_at }}</td>
            <td>{{ $work->end_at }}</td>
            <td>{{ $work->break_duration }}</td>
            <td>{{ $work->total_work_duration }}</td>
        </tr>
    @endforeach
</table>

<!-- ページネーションリンクを全体に対して表示 -->
<div class="pagination">
    {{ $works->appends(['date' => $work_date])->links() }}
</div>

@endsection