@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 40px auto; padding: 0 40px;">
    <h1>マイページ</h1>
    <p>{{ $user->name }}</p>
    <a href="/mypage/profile">プロフィール編集</a>
</div>
@endsection