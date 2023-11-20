<?php

namespace App\Exports;

use App\Models\Import;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{

    public function view(): View
    {
        $users = Import::all();
        return view('export.user-export', [
            'users' => $users
        ]);
    }
}
