<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    public function view(): View
    {
        $users = User::all();
        return view('export.user-export', [
            'users' => $users
        ]);
    }
}
