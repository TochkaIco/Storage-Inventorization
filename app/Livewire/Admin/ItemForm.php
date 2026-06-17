<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\InventoryItem;
use App\Models\Location;
use Flux;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class ItemForm extends Component
{
    use WithFileUploads;

    public $itemId;

    public $itemName = '';

    public $itemDescription = '';

    public $itemSku = '';

    public $itemQuantity = 0;

    public $itemLocationId = '';

    public $itemSpecs = [['key' => '', 'value' => '']];

    public $itemFeatureImage;

    public $existingFeatureImage;

    public function mount($itemId = null): void
    {
        if ($itemId) {
            $item = InventoryItem::findOrFail($itemId);
            $this->itemId = $item->id;
            $this->itemName = $item->name;
            $this->itemDescription = $item->description;
            $this->itemSku = $item->sku;
            $this->itemQuantity = $item->quantity;
            $this->itemLocationId = $item->location_id;
            $this->existingFeatureImage = $item->image_path;

            if (! empty($item->specifications)) {
                $this->itemSpecs = [];
                foreach ($item->specifications as $key => $value) {
                    $this->itemSpecs[] = ['key' => $key, 'value' => $value];
                }
            }
        }
    }

    public function addSpecRow(): void
    {
        $this->itemSpecs[] = ['key' => '', 'value' => ''];
    }

    public function removeSpecRow($index): void
    {
        unset($this->itemSpecs[$index]);
        $this->itemSpecs = array_values($this->itemSpecs);
    }

    public function saveItem(): void
    {
        $this->validate([
            'itemName' => 'required|string|max:255',
            'itemSku' => 'required|string|max:255|unique:inventory_items,sku,'.$this->itemId,
            'itemQuantity' => 'required|integer|min:0',
            'itemLocationId' => 'nullable|exists:locations,id',
            'itemFeatureImage' => 'nullable|sometimes|image|max:2048',
        ]);

        $formattedSpecs = [];
        foreach ($this->itemSpecs as $row) {
            if (! empty($row['key'])) {
                $formattedSpecs[$row['key']] = $row['value'];
            }
        }

        $data = [
            'name' => $this->itemName,
            'description' => $this->itemDescription,
            'sku' => $this->itemSku,
            'quantity' => $this->itemQuantity,
            'location_id' => $this->itemLocationId ?: null,
            'specifications' => $formattedSpecs,
        ];

        if ($this->itemFeatureImage instanceof TemporaryUploadedFile) {
            $data['image_path'] = $this->itemFeatureImage->store('inventory', 'public');
        }

        if ($this->itemId) {
            InventoryItem::findOrFail($this->itemId)->update($data);
            Flux::toast(variant: 'success', heading: 'Item updated.', text: 'Changes committed to master ledger.');
        } else {
            InventoryItem::create($data);
            Flux::toast(variant: 'success', heading: 'Item created.', text: 'Product initialized into active stock.');
        }

        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.admin.item-form', [
            'allLocations' => Location::all(),
        ]);
    }
}
