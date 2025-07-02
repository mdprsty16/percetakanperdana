<x-guest-layout>
    <div class="relative flex flex-col items-center justify-center min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 antialiased p-6 lg:p-8">
        
        <div class="mb-8">
            <a href="/" class="text-3xl font-bold text-gray-900 dark:text-white">
                Percetakan<span class="text-blue-600 dark:text-blue-500">Perdana</span>
            </a>
        </div>

        <x-auth-session-status class="mb-4 text-center text-sm text-green-600 dark:text-green-400" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="w-full max-w-md bg-white dark:bg-gray-800 p-8 rounded-lg shadow-lg">
            @csrf

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-6">Masuk ke Akun Anda</h2>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="email" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500" 
                    type="email" 
                    name="email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" 
                    placeholder="nama@contoh.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <div class="mb-6">
                <x-input-label for="password" :value="__('Password')" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" />
                <x-text-input 
                    id="password" 
                    class="block w-full px-4 py-2 border border-gray-300 dark:border-gray-700 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"
                    type="password"
                    name="password"
                    required 
                    autocomplete="current-password" 
                    placeholder="Minimal 8 karakter"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
            </div>

            <div class="flex items-center justify-between mb-6">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:checked:bg-blue-600 dark:checked:border-blue-600" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat saya') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                        {{ __('Lupa kata sandi Anda?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end">
                <x-primary-button class="w-full justify-center px-4 py-2 font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md transition-colors duration-200">
                    {{ __('Masuk') }}
                </x-primary-button>
            </div>

            <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-6">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200 underline">Daftar sekarang</a>
            </p>
        </form>
    </div>
</x-guest-layout>