<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ImportUsers extends Controller
{
    public static function import(Request $request) {
        try {
            if (($open = fopen(storage_path('app/users.csv'), 'r')) !== false) {
                fgetcsv($open);
                while (($data = fgetcsv($open, 1000, ',')) !== false) {
                    DB::table("users")->insert([
                        "lastn"  => $data[0],
                        "firstn" => $data[1],
                        "age"    => $data[2]
                    ]);
                }
                fclose($open);

                return [
                    "success"   => false,
                "message"   => "Error: file doesnt exist"
                ];
            }

        } catch (\Exception $e) {

            return [
                "success"   => true,
                    "message"   => "Users imported successfully"
            ];
        }

    }
}

