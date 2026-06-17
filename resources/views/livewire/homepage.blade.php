<div class="p-6 lg:p-12">

    {{-- Header & Core Controls --}}
    <div class="max-w-6xl mx-auto mb-8">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <flux:heading size="xl" level="1">Inventory</flux:heading>
            </div>

            @if(auth()->user() && auth()->user()->is_admin)
                <div>
                    <flux:button variant="primary" icon="plus" class="bg-[#1b1b18] dark:bg-[#eeeeec]">
                        {{ __('Add Item') }}
                    </flux:button>
                </div>
            @endif
        </div>

        {{-- Search Input --}}
        <div class="w-full max-w-xl">
            <flux:input
                wire:model.live.debounce.150ms="search"
                view="search"
                placeholder="{{ __('Search inventory...') }}"
                icon="magnifying-glass"
                clearable
            />
        </div>
    </div>

    {{-- Data Display Layer --}}
    <div class="max-w-6xl mx-auto">

        @if($isDatabaseEmpty)
            {{-- State A: Pristine Empty System --}}
            <div class="py-16 text-center border border-dashed border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                <flux:text class="text-[#706f6c] dark:text-[#A1A09A]">No items registered in the database yet.</flux:text>
            </div>

        @elseif(count($items) === 0)
            {{-- State B: Zero Search Results found --}}
            <div class="py-16 text-center border border-dashed border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg">
                <flux:text class="mb-3 text-[#706f6c] dark:text-[#A1A09A]">No matches found for "{{ $search }}"</flux:text>
                <flux:button size="sm" wire:click="clearSearch" variant="subtle">Clear filter</flux:button>
            </div>

        @else
            {{-- State C: Active Grid Listing --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" wire:loading.class="opacity-50 transition-opacity">
                @foreach($items as $item)
                    <div class="p-5 bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg flex flex-col justify-between">
                        <div>
                            <div class="flex items-start justify-between mb-2 gap-2">
                                <flux:text font="medium" class="text-base text-[#1C1C1A] dark:text-[#EDEDEC] truncate">
                                    {{ $item['name'] }}
                                </flux:text>
                                <flux:badge variant="neutral" size="sm" class="font-mono shrink-0">
                                    {{ $item['sku'] }}
                                </flux:badge>
                            </div>
                            <flux:subheading size="sm" class="mb-4">Qty: {{ $item['quantity'] }}</flux:subheading>
                        </div>

                        <div class="pt-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A] flex items-center gap-1.5 font-mono text-xs text-[#706f6c] dark:text-[#A1A09A]">
                            <flux:icon name="map-pin" variant="outline" class="w-3.5 h-3.5 text-[#706f6c] dark:text-[#A1A09A]" />
                            <span class="truncate">{{ $item['location_path'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
</div>
