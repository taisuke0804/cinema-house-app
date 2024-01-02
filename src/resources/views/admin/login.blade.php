<x-admins.guest-layout>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('admin.login') }}">
    @csrf

    <!-- Email Address -->
    <div>
      <x-input-label for="email" :value="__('メールアドレス')" />
      <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" 
        autofocus autocomplete="username" />
      <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-input-label for="password" :value="__('パスワード')" />

      <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" 
        autocomplete="current-password" />

      <x-input-error :messages="$errors->get('password')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">

      <x-primary-button class="ml-3">
        {{ __('ログイン') }}
      </x-primary-button>
    </div>
  </form>
</x-guest-layout>