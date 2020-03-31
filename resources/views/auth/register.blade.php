@extends('layouts.app')

@section('title', 'ユーザー登録')

@section('content')

<div class="c-container">
        <form method="post" action="{{ route('register') }}" class="p-form">
            @csrf
          <h2 class="p-form__title">ユーザー登録</h2>
          @error('name')
            <p class="p-form__errmsg">
                <strong>{{ $message }}</strong>
            </p>
          @enderror
          <div class="p-form__content">
            <span class="p-form__name">ユーザー名</span>
            <input name="name" type="text" class="p-form__input--text @error('name') p-form__input--err @enderror" value="{{ old('name') }}" required autocomplete="name" autofocus>
          </div>
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

          <div class="c-btn c-btn__container--right">
            <button type="submit" class="c-btn__btn--default">登録</button>
          </div>
        </form>
      </div>
    </div>
@endsection
