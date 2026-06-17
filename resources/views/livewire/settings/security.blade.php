<section class="w-full">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
        <flux:breadcrumbs.item href="{{ route('profile.edit') }}">{{ __('Settings') }}</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('security.edit') }}">{{ __('Security') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Security settings') }}</flux:heading>

    <x-settings.layout>
        <flux:card class="mt-6">
            <div class="mb-6">
                <flux:heading size="lg">{{ __('Active Sessions') }}</flux:heading>
                <flux:subheading>{{ __('Devices currently logged into your account.') }}</flux:subheading>
            </div>

            <div class="space-y-4">
                @foreach (auth()->user()->sessions as $session)
                    <div class="flex items-center p-3 rounded-lg border border-accent-foreground">
                        <div class="p-2 bg-accent-foreground rounded-md">
                            @if ($session->agent->isDesktop())
                                <flux:icon.computer-desktop class="size-6 text-zinc-500" />
                            @else
                                <flux:icon.device-phone-mobile class="size-6 text-zinc-500" />
                            @endif
                        </div>

                        <div class="ms-4 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold">
                                    {{ $session->agent->platform() ?: __('Unknown OS') }}
                                    ({{ $session->agent->browser() ?: __('Unknown Browser') }})
                                </span>

                                @if ($session->is_current_device)
                                    <flux:badge color="green" size="sm">{{ __('This Device') }}</flux:badge>
                                @endif
                            </div>

                            <div class="text-xs text-zinc-500 mt-0.5">
                                {{ $session->ip_address }} •
                                @if($session->is_current_device)
                                    {{ __('Active now') }}
                                @else
                                    {{ __('Last seen') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </flux:card>
    </x-settings.layout>
</section>
