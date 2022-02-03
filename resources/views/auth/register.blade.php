<style>
    header{
        font-size:40px;
    }
    .title{
        text-align:center;
        font-size:20px;
    }
    .button{
        text-align:center;
        margin-top:1rem;
    }
    .login-button{
        text-align:center;
    }
    .button-all{
        text-align:center;
    }
</style>
<x-guest-layout>
    <div class="header">
      <header><h1>Atte</h1></header>
    </div>
    <x-auth-card>
        <h1 class="title">会員登録</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- 名前 -->
            <div>
                <x-input id="name" class="block mt-1 w-full" type="text" placeholder="名前" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <!-- <x-label for="email" :value="__('Email')" /> -->

                <x-input id="email" class="block mt-1 w-full" type="email" placeholder="メールアドレス" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <!-- <x-label for="password" :value="__('Password')" /> -->

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                placeholder="パスワード"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <!-- <x-label for="password_confirmation" :value="__('Confirm Password')" /> -->

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_check"
                                placeholder="確認用パスワード"
                                required />

                                <x-auth-validation-errors class=<x-auth-validation-errors class="mb-4" :errors="$errors" />
                            </div>

            <div class="button">
                <x-button class="ml-4">
                    {{ __('会員登録') }}
                </x-button>
            </div>

            <div class="button-all">
                <div class="flex items-center justify-end mt-4">
                    <p class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ ('アカウントお持ちの方はこちらから') }}
                        </p>
                        <p><a href="/login">ログイン</a></p>
                    </div>
                    <div class="login-button">
                    </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
