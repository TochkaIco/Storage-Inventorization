<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\Location;
use Flux;
use Livewire\Component;

class LocationForm extends Component
{
    public $locationId;

    public $locationName = '';

    public $locationParentId = '';

    public function mount($locationId = null): void
    {
        if ($locationId) {
            $location = Location::findOrFail($locationId);
            $this->locationId = $location->id;
            $this->locationName = $location->name;
            $this->locationParentId = $location->parent_id;
        }
    }

    public function saveLocation(): void
    {
        $this->validate([
            'locationName' => 'required|string|max:255',
            'locationParentId' => 'nullable|exists:locations,id|not_in:'.$this->locationId,
        ]);

        $data = [
            'name' => $this->locationName,
            'parent_id' => $this->locationParentId ?: null,
        ];

        if ($this->locationId) {
            Location::findOrFail($this->locationId)->update($data);
            Flux::toast(variant: 'success', heading: 'Location updated.', text: 'Physical coordinates updated.');
        } else {
            Location::create($data);
            Flux::toast(variant: 'success', heading: 'Location saved.', text: 'New storage node mapped successfully.');
        }

        $this->dispatch('closeForm');
    }

    public function render()
    {
        return view('livewire.admin.location-form', [
            'allLocations' => Location::all(),
        ]);
    }
}
