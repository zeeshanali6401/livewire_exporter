<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = new User();

        if (isset($row['#']))
            $user->id = $row['id'];

        if (isset($row['name']))
            $user->name = $row['name'];

        if (isset($row['email']))
            $user->email = $row['email'];

        if (isset($row['auth_key']))
            $user->auth_key = $row['auth_key'];

        $user->save();
    }
}
