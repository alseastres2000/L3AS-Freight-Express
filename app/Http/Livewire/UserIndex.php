<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    protected $response;

    public $selectedData = null;
    public $editModal = false;
    public $search = null;

    public $headers = array('Fullname','Email Address','Role','Actions');

    public function boot()
    {
        $this->resetPage();
    }

    public function mount(User $users)
    {
        $this->resetPage();
        $this->response = $users->all();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function renderRole($role)
    {
        $renderedRole = null;
        switch ($role) {
            case 0:
                $renderedRole = 'Administrator';
                break;
            case 1:
                $renderedRole = 'Office Staff';
                break;
            case 2:
                $renderedRole = 'Field Staff';
                break;
            default:
                $renderedRole = 'Client';
                break;
        }
        return $renderedRole;
    }

    public function selectedUser($id)
    {
        $this->selectedData = User::findOrFail($id);
        $this->toggleModal(true);
    }

    public function toggleModal($status) {
        $this->editModal = $status;
    }

    public function render()
    {
        if(is_null($this->search)) {
            $this->response = User::paginate(5);
        } else {
            $this->response = User::search($this->search)->paginate(5);
        }
        return view('livewire.user-index',[
            'response' => $this->response,
        ]);
    }
}
