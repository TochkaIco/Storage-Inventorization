<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\InventoryItem;
use Livewire\Component;

class Homepage extends Component
{
    public $search = '';

    public $orderBy = 'name';

    public $orderDirection = 'desc';

    public function clearSearch(): void
    {
        $this->reset('search');
    }

    public function setOrder(string $field, string $direction): void
    {
        if (in_array($field, ['created_at', 'quantity', 'name']) && in_array($direction, ['asc', 'desc'])) {
            $this->orderBy = $field;
            $this->orderDirection = $direction;

            if (method_exists($this, 'resetPage')) {
                $this->resetPage();
            }
        }
    }

    public function render()
    {
        $items = InventoryItem::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('sku', 'like', '%'.$this->search.'%')
                    ->orWhere('location_id', 'like', '%'.$this->search.'%')
                    ->orderBy($this->orderBy, $this->orderDirection);
            })
            ->paginate(32);

        $isDatabaseEmpty = InventoryItem::count() === 0;

        return view('livewire.homepage', [
            'items' => $items,
            'isDatabaseEmpty' => $isDatabaseEmpty,
        ]);
    }
}
