<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Only Google OAuth logins are supported')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <flux:button variant="primary" :href="route('google.login')" icon="user-plus">{{ __('Log in') }}</flux:button>
    </div>
</x-layouts::auth>
