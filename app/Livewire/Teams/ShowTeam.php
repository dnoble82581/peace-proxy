<?php

namespace App\Livewire\Teams;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ShowTeam extends Component
{
    use WithPagination;

    public $perPage = 10;

    public $sortField = 'name';

    public $sortAsc = true;

    public $search = '';

    public $super;

    public $tenants;

    public $selectedTenant;

    public function mount(): void
    {
        if (session()->has('tenant_id')) {
            $this->super = false;
        } else {
            $this->super = true;
            $this->tenants = Tenant::all()->pluck('name', 'id')->toArray();
        }
    }

    public function render(): View
    {
        $query = User::search($this->search)
            ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc');
        if ($this->super && $this->selectedTenant) {
            $query->where('tenant_id', $this->selectedTenant);
        }

        return view('livewire.teams.show-team', [
            'users' => $query->with('documents')->paginate($this->perPage),
        ]);
    }

    public function updating($key): void
    {
        if ($key === 'search') {
            $this->resetPage();
        }
    }

    public function deleteUser($userId): void
    {
        $user = $this->findOrFailUser($userId);
        if (! is_null($user->avatar)) {
            Storage::disk('s3-public')->delete($user->avatar);
        }
        $user->delete();

    }

    private function findOrFailUser($userId): Model
    {
        return User::findOrFail($userId);
    }

    public function impersonate($userId)
    {
        if (! is_null(auth()->user()->tenant_id)) {
            return;
        }

        $originalId = auth()->user()->id;
        session()->put('impersonate', $originalId);
        auth()->loginUsingId($userId);

        return redirect('/team');
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortAsc = ! $this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }
}
