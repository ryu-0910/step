@extends('layouts.app')

@section('title', 'パスワードリマインド')

@section('content')
<div class="u-bg--default">
      <div class="c-container">
        <form method="POST" action="{{ route('password.email') }}" class="p-form">
            @csrf
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


          <div class="c-btn__container--right">
            <button type="submit" class="c-btn c-btn__btn--default">送信</button>
          </div>
        </form>
      </div>
    </div>
@endsection