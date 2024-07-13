<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>coachtech-furima</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
        @yield('css')
    </head>
    <header class="header">
        <img src="img/logo.svg" alt="coachtech" width="280" height="80">
            @yield('link')
    </header>
    <body>
        <main>
            @yield('content')
        </main>
    </body>
</html>