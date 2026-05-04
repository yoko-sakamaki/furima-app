@extends('layouts.auth')

@section('content')
<div class="form-wrapper">
    <h1 class="form-title">メール認証</h1>
    <p>登録したメールアドレスに認証メールを送信しました。</p>
    <p>メール内の「Verify Email Address」ボタンを押して認証を完了してください。</p>

    <form action="/email/verification-notification" method="POST">
        @csrf
        <button type="submit" class="btn-primary" style="margin-top:24px;">認証メールを再送する</button>
    </form>
</div>
@endsection