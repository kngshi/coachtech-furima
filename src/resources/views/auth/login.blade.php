<x-guest-layout>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>coachtech-furima</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
    </head>
    <body>
        <header class="header">
            <a href="/">
                <img src="/img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
            </a>
        </header>
        <div class="login-ttl">
            <p class="login-ttl">ログイン</p>
        </div>
        <div class="auth-container">
            <x-auth-card>
                <x-auth-session-status class="mb-4" :status="session('status')" />
                <x-auth-validation-errors class="mb-4" :errors="$errors" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div>
                        <x-label for="email" :value="__('メールアドレス')" class="email-label"/>
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    </div>
                    <div class="mt-4">
                        <x-label for="password" :value="__('パスワード')" class="password-label" />
                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password" />
                    </div>
                    <div class="login-form">
                        <x-button class="login-button">
                            {{ __('ログインする') }}
                        </x-button>
                    </div>
                </form>
                <div class="register-link">
                    <a class="register-link" href="{{ route('register') }}">
                        {{ __('会員登録はこちら') }}
                    </a>
                </div>
            </x-auth-card>
        </div>
    </body>
</x-guest-layout>