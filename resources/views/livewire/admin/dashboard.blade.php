<div class="p-6 lg:p-12 max-w-7xl mx-auto space-y-8">
    <flux:breadcrumbs class="mb-6">
        <flux:breadcrumbs.item href="{{ route('home') }}" icon="home" />
        <flux:breadcrumbs.item href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    @if(!$isEditingOrCreating)
        {{-- READ VIEW BLOCK LAYOUT --}}
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl" level="1">{{ __('Inventory Dashboard') }}</flux:heading>
                <flux:subheading>{{ __('Overview and active tracking system management.') }}</flux:subheading>
            </div>
            <div>
                @if($activeTab === 'items')
                    <flux:button variant="primary" icon="plus" wire:click="triggerCreate('item')">{{ __('Add Item') }}</flux:button>
                @else
                    <flux:button variant="primary" icon="plus" wire:click="triggerCreate('location')">{{ __('Add Location') }}</flux:button>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-xl">
                <flux:text size="sm" class="text-zinc-500 uppercase font-semibold tracking-wider">{{ __('Total Unique Items') }}</flux:text>
                <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">{{ $totalItemsCount }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-xl">
                <flux:text size="sm" class="text-zinc-500 uppercase font-semibold tracking-wider">{{ __('Total Stock Volume') }}</flux:text>
                <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">{{ $totalStockVolume }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 rounded-xl">
                <flux:text size="sm" class="text-zinc-500 uppercase font-semibold tracking-wider">{{ __('Managed Storage Locations') }}</flux:text>
                <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100 mt-2">{{ $totalLocationsCount }}</div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="border-b border-zinc-200 dark:border-zinc-800 flex gap-4">
                <button wire:click="$set('activeTab', 'items')" class="pb-3 px-1 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'items' ? 'border-zinc-900 dark:border-zinc-100 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-500 hover:text-zinc-700' }}">
                    {{ __('Inventory Items') }}
                </button>
                <button wire:click="$set('activeTab', 'locations')" class="pb-3 px-1 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'locations' ? 'border-zinc-900 dark:border-zinc-100 text-zinc-900 dark:text-zinc-100' : 'border-transparent text-zinc-500 hover:text-zinc-700' }}">
                    {{ __('Storage Locations') }}
                </button>
            </div>

            @if($activeTab === 'items')
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg overflow-hidden w-full">
                    @if($items->isEmpty())
                        <div class="p-12 text-center text-zinc-500 dark:text-zinc-400">{{ __('No items added yet.') }}</div>
                    @else
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column width="3rem"></flux:table.column>
                                <flux:table.column>{{ __('Item Details') }}</flux:table.column>
                                <flux:table.column>{{ __('SKU') }}</flux:table.column>
                                <flux:table.column align="center">{{ __('Qty') }}</flux:table.column>
                                <flux:table.column>{{ __('Assigned Location') }}</flux:table.column>
                                <flux:table.column align="end"></flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach($items as $item)
                                    <flux:table.row :key="'item-'.$item->id">
                                        <flux:table.cell>
                                            @if($item->image_path)
                                                <img src="{{ asset('storage/' . $item->image_path) }}" class="w-8 h-8 rounded object-cover border border-zinc-200 dark:border-zinc-700">
                                            @else
                                                <div class="w-8 h-8 rounded bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-xs font-mono text-zinc-400 dark:text-zinc-600 select-none">📦</div>
                                            @endif
                                        </flux:table.cell>
                                        <flux:table.cell>
                                            <div class="font-medium text-zinc-950 dark:text-zinc-100">{{ $item->name }}</div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400 max-w-xs truncate">{{ $item->description }}</div>
                                        </flux:table.cell>
                                        <flux:table.cell class="font-mono text-xs text-zinc-600 dark:text-zinc-400">{{ $item->sku }}</flux:table.cell>
                                        <flux:table.cell align="center" class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $item->quantity }}</flux:table.cell>
                                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400 text-xs font-mono">{{ $item->location ? $item->location->name : '—' }}</flux:table.cell>
                                        <flux:table.cell align="end">
                                            <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="triggerEdit('item', {{ $item->id }})" />
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                        @if($items->hasPages())
                            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800"><flux:pagination :paginator="$items" /></div>
                        @endif
                    @endif
                </div>
            @endif

            @if($activeTab === 'locations')
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-lg overflow-hidden w-full">
                    @if($locations->isEmpty())
                        <div class="p-12 text-center text-zinc-500 dark:text-zinc-400">{{ __('No locations mapped yet.') }}</div>
                    @else
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column>{{ __('Location Name') }}</flux:table.column>
                                <flux:table.column>{{ __('Parent Hierarchy Map') }}</flux:table.column>
                                <flux:table.column align="end"></flux:table.column>
                            </flux:table.columns>

                            <flux:table.rows>
                                @foreach($locations as $loc)
                                    <flux:table.row :key="'loc-'.$loc->id">
                                        <flux:table.cell class="font-medium text-zinc-950 dark:text-zinc-100">{{ $loc->name }}</flux:table.cell>
                                        <flux:table.cell class="text-zinc-500 dark:text-zinc-400 font-mono text-xs">{{ $loc->parent ? $loc->parent->name : __('Top-Level Structural Tier') }}</flux:table.cell>
                                        <flux:table.cell align="end">
                                            <flux:button size="sm" variant="ghost" icon="pencil-square" wire:click="triggerEdit('location', {{ $loc->id }})" />
                                        </flux:table.cell>
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                        @if($locations->hasPages())
                            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800"><flux:pagination :paginator="$locations" /></div>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    @elseif($formContext === 'item')
        <livewire:admin.item-form :itemId="$targetModelId" />
    @elseif($formContext === 'location')
        <livewire:admin.location-form :locationId="$targetModelId" />
    @endif
</div>
