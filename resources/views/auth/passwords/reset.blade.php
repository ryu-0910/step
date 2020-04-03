@extends('layouts.app')

@section('title', 'パスワードリセット')

@section('content')
<div class="u-bg--default">
      <div class="c-container">
        <form method="post" action="{{ route('password.update') }}" class="p-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
          <h2 class="p-form__title">パスワードリセット</h2>

          @error('email')
            <p class="p-form__errmsg">
                <strong>{{ $message }}</strong>
            </p>
          @enderror
          <div class="p-form__content">
            <span class="p-form__name">メールアドレス</span>
            <input name="email" type="email" class="p-form__input--text @error('email') p-form__input--err @enderror" value="{{ old('email') }}" required autocomplete="email" autofocus>
          </div>

          @error('password')
            <p class="p-form__errmsg">
                <strong>{{ $message }}</strong>
            </p>
          @enderror
          <div class="p-form__content">
            <span class="p-form__name">パスワード</span>
            <input name="password" type="password" class="p-form__input--text @error('password') p-form__input--err @enderror" required autocomplete="password" autofocus>
          </div>

          <div class="p-form__content">
            <span class="p-form__name">パスワード再入力</span>
            <input name="password_confirmation" type="password" class="p-form__input--text" required autocomplete="new-password">
          </div>


          <div class="c-btn__container--right">
            <button type="submit" class="c-btn c-btn__btn--default">リセット</button>
          </div>
        </form>
      </div>
    </div>
@endsection

