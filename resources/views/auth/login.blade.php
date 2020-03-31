@extends('layouts.app')

@section('title', 'ログイン')

@section('content')
<div class="u-bg--default">
      <div class="c-container">
        <form method="post" action="{{ route('login') }}" class="p-form">
            @csrf
          <h2 class="p-form__title">ログイン</h2>

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
          @if (Route::has('password.request'))
            <span>パスワードを忘れた方は<a class="u-font--bold" href="{{ route('password.request') }}">コチラ</a></span>
          @endif
          </div>

          <input class="p-form__checkbox" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">   
                                    次回自動でログインする
                                    </label>

          <div class="c-btn__container--right">
            <button type="submit" class="c-btn c-btn__btn--default">ログイン</button>
          </div>
        </form>
      </div>
    </div>
@endsection
