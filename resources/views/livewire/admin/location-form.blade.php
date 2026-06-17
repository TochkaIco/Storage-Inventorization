<div class="max-w-xl mx-auto space-y-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-2xl shadow-sm">
    <div>
        <flux:heading size="lg">{{ $locationId ? __('Modify Storage Matrix Node') : __('Define New Facilities Zone Node') }}</flux:heading>
        <flux:subheading>{{ __('Establish warehouse shelf, bin routing indexes, or zone nesting parameters.') }}</flux:subheading>
    </div>

    <form wire:submit.prevent="saveLocation" class="space-y-5">
        <flux:input wire:model="locationName" label="Location Structural Name" placeholder="e.g., Room A, Shelf 2, Cabinet Alpha" required />

        <flux:select wire:model="locationParentId" label="Nests Inside Parent Container (Optional)">
            <flux:select.option value="">{{ __('Root Level Tier (Standalone structural zone space)') }}</flux:select.option>
            @foreach($allLocations as $loc)
                @if($loc->id !== $locationId)
                    <flux:select.option value="{{ $loc->id }}">{{ $loc->name }}</flux:select.option>
                @endif
            @endforeach
        </flux:select>

        @if ($errors->any())
            <div class="p-3 bg-red-50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/50 rounded-lg text-xs text-red-600 dark:text-red-400">
                <ul class="list-disc pl-4 space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex gap-2 justify-end pt-4 border-t border-zinc-100 dark:border-zinc-800">
            <flux:button variant="ghost" wire:click="$dispatch('closeForm')">{{ __('Cancel and Return') }}</flux:button>
            <flux:button type="submit" variant="primary">{{ __('Save Location Node') }}</flux:button>
        </div>
    </form>
</div>
