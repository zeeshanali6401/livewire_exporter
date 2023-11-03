<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Livewire\WithFileUploads;

use Maatwebsite\Excel\Facades\Excel;

class Home extends Component
{
    use WithFileUploads;
    public $name, $email, $auth_key, $user_id;
    public $deleteUserId, $file;


    public function render()
    {
        $collection = User::where('email', '!=', auth()->user()->email)->get();
        return view('livewire.home', [
            'collection' => $collection
        ]);
    }
    public function import()
    {
        // $this->validate([
        //     'name' => 'required',
        //     'file' => 'required|file|mimes:png,jpg,xls,xlsx,doc,docx,ppt,pptx,pdf|max:1024',
        // ]);
        Excel::import(new UsersImport, $this->file, null, Excel::CSV);
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function delete()
    {
        $user = User::find($this->deleteUserId);
        if (!is_null($user)) {
            $user->delete();
        }
        $this->dispatch('hideModal');
    }
    public function dltModalShow($id)
    {
        $this->deleteUserId = $id;
        $this->dispatch('showModal');
    }
    public function resetData()
    {
        $this->name = null;
        $this->email = null;
        $this->auth_key = null;
        $this->deleteUserId = null;
    }
    public function edit($id)
    {
        $user = User::find($id);
        $this->user_id = $id;
        $this->name = $user['name'];
        $this->email = $user['email'];
        $this->auth_key = $user['auth_key'];

        $this->dispatch('showEditModal');
    }
    public function update()
    {
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->update();
        $this->dispatch('hideModal');
    }
}
