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
    public $name, $email, $auth_key, $QR, $user_id, $details = null;
    public $deleteUserId, $file, $counter;
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'file' => 'required|file|mimes:csv|max:1024',
    ];
    public function render()
    {
        $this->counter = User::where('id', '!=', auth()->user()->id)->count();
        $collection = User::where('email', '!=', auth()->user()->email)->paginate(13);
        return view('livewire.home', [
            'collection' => $collection,
            'QR' => $this->QR,
        ]);
    }
    public function updated($field)
    {
        $this->validateOnly($field, [
            'file' => 'required|file|mimes:csv|max:1024',
        ]);
    }
    public function import()
    {
        $this->validate([
            'file' => 'required|file|mimes:csv|max:1024',
        ]);
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
    public function confirm()
    {
        Mail::to($this->email)->send(new ConfirmationMail($this->details));
        $this->dispatch('hideModal');
        $this->dispatch('confirm_swal');
    }
    public function showConfirmMailModal($id)
    {
        $this->email = User::where('id', $id)->pluck('email')->first();
        $this->details = User::where('id', $id)->first();
        $this->dispatch('showConfirmMailModal');
    }
    public function rejectMailModal($id)
    {
        $this->email = User::where('id', $id)->pluck('email')->first();
        $this->dispatch('rejectMailModal');
    }
    public function reject()
    {
        Mail::to($this->email)->send(new RejectMail);
        $this->dispatch('hideModal');
        $this->dispatch('reject_swal');
    }
    public function update()
    {
        $user = User::find($this->user_id);
        $user->name = $this->name;
        $user->email = $this->email;
        $user->update();
        $this->dispatch('hideModal');
    }
    public function qr_show($id)
    {
        $this->dispatch('showQrModal');
        $this->QR = User::where('id', $id)->pluck('auth_key')->first();
    }
    public function qr_gen()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();

        foreach ($users as $user) {
            if (!file_exists(public_path() . "/qr/{$user->auth_key}.png")) {
                storeImageFromUrl("https://api.qrserver.com/v1/create-qr-code/?data={$user->auth_key}&size=300x300", "/qr/{$user->name}.png");
            }
        }
    }
}
