@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/user_list.css') }}">
@endsection

@section('headerLinks')
<div class="headerLinks">
    <form class="form" action="/" method="GET">
        @csrf
        <button class="header-nav__button">ホーム</button>
    </form>
    <form class="form" action="/time_record" method="GET">
        @csrf
        <button class="header-nav__button">日付一覧</button>
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
    <div class="title">ユーザー情報一覧</div>
</div>
<table class="userList">
    <tr>
        <th>ユーザー名</th>
        <th>メールアドレス</th>
        <th>登録日</th>
        <th>更新日</th>
        <th>勤怠詳細</th>
    </tr>
    @foreach ($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}</td>
            <td>{{ $user->updated_at }}</td>
            <td>
                <form action="/time_record_forOtherUsers" method="GET">
                    @csrf
                    <button class="work_detail">勤怠詳細</button>
                </form>
            </td>
        </tr>
    @endforeach
</table>
</div>
<div class="pagination">
    {{ $users->links() }} <!-- カスタムビューを指定 -->
    @endsection