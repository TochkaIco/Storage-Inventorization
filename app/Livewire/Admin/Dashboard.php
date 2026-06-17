<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\InventoryItem;
use App\Models\Location;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public $activeTab = 'items';

    public $isEditingOrCreating = false;

    public $formContext = '';

    public $targetModelId;

    protected $queryString = ['activeTab'];

    // Listeners catch form triggers from child elements or inline clicks
    protected $listeners = [
        'closeForm' => 'handleFormClose',
    ];

    public function triggerCreate($type): void
    {
        $this->targetModelId = null;
        $this->formContext = $type;
        $this->isEditingOrCreating = true;
    }

    public function triggerEdit($type, $id): void
    {
        $this->targetModelId = $id;
        $this->formContext = $type;
        $this->isEditingOrCreating = true;
    }

    public function handleFormClose(): void
    {
        $this->isEditingOrCreating = false;
        $this->formContext = '';
        $this->targetModelId = null;
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'items' => InventoryItem::with('location')->latest()->paginate(10, ['*'], 'itemsPage'),
            'locations' => Location::with('parent')->latest()->paginate(10, ['*'], 'locationsPage'),
            'totalItemsCount' => InventoryItem::count(),
            'totalStockVolume' => InventoryItem::sum('quantity'),
            'totalLocationsCount' => Location::count(),
        ]);
    }
}
