<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Livewire\WithFileUploads;
use App\Mail\ConfirmationMail;
use App\Mail\RejectMail;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $email, $auth_key, $QR, $user_id;
    public $deleteUserId, $file;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $collection = User::where('email', '!=', auth()->user()->email)->paginate(7);
        return view('livewire.home', [
            'collection' => $collection,
            'QR' => $this->QR,
        ]);
    }
    public function import()
    {

        Excel::import(new UsersImport, $this->file, \Maatwebsite\Excel\Excel::CSV);
        $this->render();
    }
    public function export()
    {
        return Excel::download(new UsersExport, 'users.csv');
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
    public function confirm(){
        Mail::to($this->email)->send(new ConfirmationMail);
        $this->dispatch('hideModal');
    }
    public function showConfirmMailModal($id){
        $this->email = User::where('id', $id)->pluck('email')->first();
        $this->dispatch('showConfirmMailModal');
    }
    public function rejectMailModal($id){
        $this->email = User::where('id', $id)->pluck('email')->first();
        $this->dispatch('rejectMailModal');
    }
    public function reject(){
        Mail::to($this->email)->send(new RejectMail);
        $this->dispatch('hideModal');
    }
    public function update()
    {
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->update();
        $this->dispatch('hideModal');
    }
    public function qr($id){
        $this->dispatch('showQrModal');
        $this->QR = User::where('id', $id)->pluck('auth_key')->first();
    }
}
