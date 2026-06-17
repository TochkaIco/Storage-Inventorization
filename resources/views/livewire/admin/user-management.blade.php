<div class="p-6 lg:p-12">
    <div class="max-w-5xl mx-auto">

        <flux:breadcrumbs class="mb-6">
            <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
            <flux:breadcrumbs.item href="{{ route('admin.users') }}">{{ __('Users') }}</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <div class="mb-8">
            <flux:heading size="xl" level="1">{{ __('User Management') }}</flux:heading>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div class="flex-1 w-full">
                <flux:input
                    wire:model.live.debounce.200ms="search"
                    view="search"
                    placeholder="{{ __('Search users by name or email...') }}"
                    icon="magnifying-glass"
                />
            </div>

            <div class="shrink-0 items-center">
                <flux:checkbox
                    wire:model.live="onlyAdmins"
                    label="{{ __('Only show admins') }}"
                />
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg overflow-hidden w-full px-4">
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Name</flux:table.column>
                    <flux:table.column>Email</flux:table.column>
                    <flux:table.column align="center">Role</flux:table.column>
                    <flux:table.column align="end">Actions</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @foreach($users as $user)
                        <flux:table.row :key="$user->id">

                            <flux:table.cell class="font-medium text-zinc-950 dark:text-zinc-100">
                                <div class="flex items-center gap-3">
                                    <flux:avatar src="{{ $user->profile_picture }}" name="{{ $user->name }}" size="sm" class="bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300" />
                                    <span>{{ $user->name }}</span>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell class="text-zinc-500 dark:text-zinc-400">
                                {{ $user->email }}
                            </flux:table.cell>

                            <flux:table.cell align="center">
                                @if($user->is_admin)
                                    <flux:badge variant="neutral" size="sm" class="font-mono text-[10px] uppercase tracking-wider mx-auto">
                                        Admin
                                    </flux:badge>
                                @else
                                    <span class="text-xs text-zinc-400 dark:text-zinc-600 font-mono">—</span>
                                @endif
                            </flux:table.cell>

                            {{-- Action Triggers --}}
                            <flux:table.cell align="end">
                                @if($user->id !== auth()->id())
                                    <flux:button
                                        size="sm"
                                        variant="ghost"
                                        wire:click="toggleAdmin({{ $user->id }})"
                                        class="text-xs font-medium text-zinc-700 dark:text-zinc-300"
                                    >
                                        {{ $user->is_admin ? 'Revoke Admin' : 'Make Admin' }}
                                    </flux:button>
                                @else
                                    <span class="text-xs italic text-zinc-400 dark:text-zinc-600 pr-3 select-none">
                                        {{ __('You (Current)') }}
                                    </span>
                                @endif
                            </flux:table.cell>

                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>

            @if($users->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-800"><flux:pagination :paginator="$users" /></div>
            @endif
        </div>
    </div>
</div>
