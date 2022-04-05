<?php

namespace App\Http\Livewire;

use ZipArchive;

use App\Models\User;
use App\Models\Inventory;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Http\Response;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InventoryIndex extends Component
{
    use WithPagination;

    protected $response;

    public $selectedData = null;
    public $fieldStaff = null;
    public $clientList = null;
    public $search = null;

    public $editModal = false;
    public $verifyModal = false;
    public $approveModal = false;
    public $finalModal = false;

    public $headers = array('Reference ID','Package Name','No. of Items','Weight','Cost','Status','Actions');

    public function boot()
    {
        $this->resetPage();
    }

    public function mount(Inventory $inventories, User $users)
    {
        $this->resetPage();
        $this->response = $inventories->all();
        $this->fieldStaff = $users->where('role',2)->get();
        $this->clientList = $users->where('role',3)->get();
    }

    public function updating()
    {
        $this->resetPage();
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function itemAttachments($id)
    {
        $item = Inventory::findOrFail($id);
        $headers = ['Content-Type' => 'application/octet-stream'];
        $pathToFile = storage_path('app/public/attachments/'.$item->code);
        $fileName = $item->code.'_'.$item->name.'.zip';
        $filePath = $pathToFile.'/'.$fileName;

        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        $zip = new ZipArchive();

        if ($zip->open($filePath, ZipArchive::CREATE) === true) {
            $zipFiles = File::files($pathToFile);
            foreach ($zipFiles as $key => $value) {
                $relativePath = basename($value);
                $zip->addFile($value, $relativePath);
            }
        }

        $zip->close();

        return response()->download($filePath, $fileName, $headers)->deleteFileAfterSend(true);
    }

    public function renderStatus($status)
    {
        $renderedStatus = null;
        switch ($status) {
            case 1:
                $renderedStatus = 'Verification';
                break;
            case 2:
                $renderedStatus = 'Approved';
                break;
            case 3:
                $renderedStatus = 'Rejected';
                break;
            case 4:
                $renderedStatus = 'Started';
                break;
            case 5:
                $renderedStatus = 'Cancelled';
                break;
            case 6:
                $renderedStatus = 'Completed';
                break;
            default:
                $renderedStatus = 'Pending';
                break;
        }
        return $renderedStatus;
    }

    public function renderColor($status)
    {
        $renderedColor = null;
        switch ($status) {
            case 0:
                $renderedColor = 'text-amber-600';
                break;
            case 1:
                $renderedColor = 'text-yellow-600';
                break;
            case 2:
                $renderedColor = 'text-green-600';
                break;
            case 3:
                $renderedColor = 'text-red-600';
                break;
            case 4:
                $renderedColor = 'text-blue-600';
                break;
            case 5:
                $renderedColor = 'text-rose-600';
                break;
            case 6:
                $renderedColor = 'text-teal-600';
                break;
            default:
                $renderedColor = 'text-gray-900';
                break;
        }
        return $renderedColor;
    }

    public function selectedItem($id,$action)
    {
        $this->selectedData = Inventory::findOrFail($id);
        $this->toggleModal(true,$action);
    }

    public function toggleModal($status,$action) {
        if($action == 'edit') {
            $this->editModal = $status;
        } else if($action == 'verify') {
            $this->verifyModal = $status;
        } else if($action == 'approved') {
            $this->approveModal = $status;
        } else if($action == 'final') {
            $this->finalModal = $status;
        }

        if($status == false)
        {
            $this->resetPage();
        }
    }

    public function finalStatus($id,$status)
    {
        $item = Inventory::findOrFail($id);
        $item->status = $status;
        $item->save();
    }

    public function render()
    {
        if(is_null($this->search)) {
            if(auth()->user()->role == 3)
            {
                $this->response = Inventory::where('created_by',auth()->user()->id)->paginate(5);
            } elseif(auth()->user()->role == 2)
            {
                $this->response = Inventory::where('processed_by',auth()->user()->id)->paginate(5);
            } else {
                $this->response = Inventory::paginate(5);
            }
        } else {
            if(auth()->user()->role == 3)
            {
                $this->response = Inventory::where('created_by',auth()->user()->id)->search($this->search)->paginate(5);
            } elseif(auth()->user()->role == 2)
            {
                $this->response = Inventory::where('processed_by',auth()->user()->id)->search($this->search)->paginate(5);
            } else {
                $this->response = Inventory::search($this->search)->paginate(5);
            }
        }

        return view('livewire.inventory-index',[
            'response' => $this->response,
        ]);
    }
}
