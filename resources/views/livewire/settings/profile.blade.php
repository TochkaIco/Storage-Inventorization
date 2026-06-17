<section class="w-full">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
        <flux:breadcrumbs.item href="{{ route('profile.edit') }}">{{ __('Settings') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('profile.edit') }}">{{ __('Profile') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout wire:key="settings-layout" :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            @if(auth()->user()->profile_picture)
                <flux:avatar :src="auth()->user()->profile_picture" :name="auth()->user()->name" :initials="auth()->user()->initials()" class="h-24 w-24 mb-2" circle />
                <flux:text class="mt-1 text-xs text-orange-400/80 cursor-default">{{ __('Your profile picture is handled by Google.') }}</flux:text>
                <flux:button wire:click="pullPictureFromGoogle()" class="cursor-pointer" icon="arrow-path" variant="ghost">{{ __('Pull the picture from Google') }}</flux:button>
            @else
                <flux:avatar :name="auth()->user()->name" :initials="auth()->user()->initials()" class="h-24 w-24 mb-2" circle />
            @endif

            <div>
                <flux:input wire:model="name" :label="__('Name')" type="text" disabled required autofocus autocomplete="name" />
            </div>

            <div>
                <flux:input wire:model="email" :label="__('Email')" disabled />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="button" class="w-full cursor-not-allowed">{{ __('Save') }}</flux:button>
                </div>
            </div>
        </form>

        @auth
            <livewire:settings.delete-user-form />
        @endauth
    </x-settings.layout>
</section>
