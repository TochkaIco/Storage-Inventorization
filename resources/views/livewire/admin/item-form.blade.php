<div class="max-w-2xl mx-auto space-y-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-8 rounded-2xl shadow-sm">
    <div>
        <flux:heading size="lg">{{ $itemId ? __('Modify Inventory Item Details') : __('Create New Stock Asset Profile') }}</flux:heading>
        <flux:subheading>{{ __('Complete product serialization metrics, location mappings, and structural variables.') }}</flux:subheading>
    </div>

    <form wire:submit.prevent="saveItem" class="space-y-5">
        <flux:input wire:model="itemName" label="Item Name" placeholder="e.g., Surface Mount Resistor" required />
        <flux:textarea wire:model="itemDescription" label="Description (Optional)" placeholder="Provide internal technical engineering context variables..." rows="4" />

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <flux:input wire:model="itemSku" label="SKU Identifier" placeholder="e.g., RES-10K-0805" required />
            <flux:input type="number" wire:model="itemQuantity" label="Initial On-Hand Qty" required />
        </div>

        <flux:select wire:model="itemLocationId" label="Storage Designation Location">
            <flux:select.option value="">{{ __('Unassigned / Floating Stock Pile') }}</flux:select.option>
            @foreach($allLocations as $loc)
                <flux:select.option value="{{ $loc->id }}">{{ $loc->name }}</flux:select.option>
            @endforeach
        </flux:select>

        <div class="space-y-2">
            <flux:label>{{ __('Feature Image') }}</flux:label>
            @if($existingFeatureImage && !$itemFeatureImage)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $existingFeatureImage) }}" class="w-24 h-24 rounded-lg object-cover border border-zinc-200 dark:border-zinc-800">
                </div>
            @endif
            <input type="file" wire:model="itemFeatureImage" class="block w-full text-xs text-zinc-500 dark:text-zinc-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 dark:file:bg-zinc-800 file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700" />
        </div>

        <div class="space-y-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
            <div class="flex items-center justify-between">
                <flux:label class="font-medium text-zinc-900 dark:text-zinc-100">{{ __('Technical Specifications Schema (JSON)') }}</flux:label>
                <flux:button size="sm" variant="ghost" icon="plus" wire:click.prevent="addSpecRow">{{ __('Add Metric Variable') }}</flux:button>
            </div>

            <div class="space-y-2">
                @foreach($itemSpecs as $index => $spec)
                    <div class="flex items-center gap-2" :key="'spec-row-'.$index">
                        <flux:input wire:model="itemSpecs.{{ $index }}.key" placeholder="Key (e.g., Tolerance)" dense class="flex-1" />
                        <flux:input wire:model="itemSpecs.{{ $index }}.value" placeholder="Value (e.g., ±1%)" dense class="flex-1" />
                        <flux:button size="sm" variant="ghost" icon="trash" class="text-zinc-400 hover:text-red-500 dark:hover:text-red-400" wire:click.prevent="removeSpecRow({{ $index }})" />
                    </div>
                @endforeach
            </div>
        </div>

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
            <flux:button type="submit" variant="primary">{{ __('Commit Changes') }}</flux:button>
        </div>
    </form>
</div>
