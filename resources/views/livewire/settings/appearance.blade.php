<section class="w-full">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
        <flux:breadcrumbs.item href="{{ route('profile.edit') }}">{{ __('Settings') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('appearance.edit') }}">{{ __('Appearance') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Appearance settings') }}</flux:heading>

    <x-settings.layout :heading="__('Appearance')" :subheading=" __('Update the appearance settings for your account')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Light') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Dark') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('System') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>
