<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | STEP</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
</head>
<body>
    <div id="app">
        <header id="l-header">
            <div class="p-header">
                <h1 class="p-header__title"><a href="{{ route('step.index') }}">STEP</a></h1>
                <div class="p-menu-trigger js-toggle-sp-menu">
                  <span class="p-menu-trigger__bar"></span>
                  <span class="p-menu-trigger__bar"></span>
                  <span class="p-menu-trigger__bar"></span>
                </div>
                <ul class="p-navmenu js-toggle-sp-target">
                  @guest
                    <li class="p-navmenu__item"><a href="{{ route('step.list') }}" class="p-navmenu__link">STEP一覧</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('register') }}" class="p-navmenu__link">ユーザー登録</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('login')}}" class="p-navmenu__link">ログイン</a></li>
                  @endguest
                  @auth
                    <li class="p-navmenu__item"><a href="{{ route('step.list') }}" class="p-navmenu__link">STEP一覧</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('step.mypage') }}" class="p-navmenu__link">マイページ</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('steps.new') }}" class="p-navmenu__link">STEP登録</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('prof.edit') }}" class="p-navmenu__link">プロフィール編集</a></li>
                    <li class="p-navmenu__item"><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="p-navmenu__link">ログアウト</a>
                                                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form></li>
                  @endauth
                </ul>
            </div>
            <!-- フラッシュメッセージ -->
            <div class="p-flash-msg" id="js-toggle-msg">
                {{ session('flash_message') }}
            </div>
        </header>
       
  
        <main id="l-main">
            @yield('content')
        </main>
    </div>
    <footer id="l-footer">
      <span>Copyright ©︎ STEP All Rights Reserved.</span>
      <span><a href="https://github.com/ryu-0910/step">GitHub</a></span>
  </footer>
</body>
</html>
