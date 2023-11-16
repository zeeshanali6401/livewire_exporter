<?php

namespace App\Imports;

use App\Models\Import;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Str;


class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $import = new Import();
        if (isset($row['s/n'])) {
            $import->id = $row['id'];
        }
        if (isset($row['name'])) {
            $import->name = $row['name'];
        }
        if (isset($row['division'])){
            $import->division = $row['division'];
        }
        if (isset($row['email'])){
            $import->email = $row['email'];
        }
        if (isset($row['assigned_table'])){
            $import->assigned_table = $row['assigned_table'];
        }
        if (isset($row['lucky_draw_bladklist'])){
            $import->lucky_draw_bladklist = $row['lucky_draw_bladklist'];
        }
        if (isset($row['lucky_draw_number'])){
            $import->lucky_draw_number = $row['lucky_draw_number'];
        }
        if (isset($row['dietary_prefrences'])){
            $import->dietary_prefrences = $row['dietary_prefrences'];
        }
        if (!empty($row['auth_key'])) { {
                $import->auth_key = $row['auth_key'];
            }
        } else {
            $import->auth_key = Str::random(16);
        }
        $import->save();
        // $import = new import();
        // if (isset($row['#'])) {
        //     $import->id = $row['id'];
        // }
        // if (isset($row['name'])) {
        //     $import->name = $row['name'];
        // }
        // if (isset($row['email']))
        //     $import->email = $row['email'];

        // if (!empty($row['auth_key'])) { {
        //         $import->auth_key = $row['auth_key'];
        //     }
        // } else {
        //     $import->auth_key = Str::random(16);
        // }
        // $import->save();
    }
}
