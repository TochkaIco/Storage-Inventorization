<?php

declare(strict_types=1);

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public $search = '';

    public $onlyAdmins = false;

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingOnlyAdmins(): void
    {
        $this->resetPage();
    }

    public function toggleAdmin(int $userId): void
    {
        Gate::authorize('admin');

        $user = User::findOrFail($userId);

        if ($user->id === auth()->id()) {
            return;
        }

        $user->update([
            'is_admin' => ! $user->is_admin,
        ]);
    }

    public function render()
    {
        Gate::authorize('admin');

        $query = User::latest()
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->onlyAdmins, function ($query) {
                $query->where('is_admin', true);
            });

        return view('livewire.admin.user-management', [
            'users' => $query->paginate(10),
        ]);
    }
}
