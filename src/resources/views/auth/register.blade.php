<x-guest-layout>
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>coachtech-furima</title>
        <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
    </head>
    <body>
        <header class="header">
            <a href="/">
                <img src="/img/logo.svg" alt="coachtech" width="280" height="80" class="header-logo">
            </a>
        </header>
        <main>
            <div class="register-ttl">
                <p class="register-ttl">会員登録</p>
            </div>
            <div class="auth-container">
                <x-auth-card>
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="mt-4">
                            <x-label for="name" :value="__('Name')" class="name-label"/>
                            <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                        </div>
                        <div class="mt-4">
                            <x-label for="email" :value="__('メールアドレス')" class="email-label"/>
                            <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        </div>
                        <div class="mt-4">
                            <x-label for="password" :value="__('パスワード')" class="password-label"/>
                            <x-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
                        </div>
                        <div class="mt-4">
                            <x-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-input id="password_confirmation" class="block mt-1 w-full"
                                            type="password"
                                            name="password_confirmation" required />
                        </div>
                        <div class="mt-4">
                            <x-button class="register-button">
                                {{ __('登録する') }}
                            </x-button>
                        </div>
                    </form>
                    <div class="login-link">
                        <a class="login-link" href="{{ route('login') }}">
                            {{ __('ログインはこちら') }}
                        </a>
                    </div>
                </x-auth-card>
            </div>
        </main>
    </body>
</x-guest-layout>
