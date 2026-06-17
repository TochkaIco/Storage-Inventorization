<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\InventoryItem;
use Livewire\Component;

class Homepage extends Component
{
    public $search = '';

    public function clearSearch(): void
    {
        $this->reset('search');
    }

    public function render()
    {
        $items = InventoryItem::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('sku', 'like', '%'.$this->search.'%')
                    ->orWhere('location_id', 'like', '%'.$this->search.'%');
            })
            ->get();

        $isDatabaseEmpty = InventoryItem::count() === 0;

        return view('livewire.homepage', [
            'items' => $items,
            'isDatabaseEmpty' => $isDatabaseEmpty,
        ]);
    }
}
