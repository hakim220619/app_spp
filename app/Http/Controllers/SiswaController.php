<?php

namespace App\Http\Controllers;

use App\Models\Master\Siswa;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function index()
    {
        $data = [];
        for ($i = 1; $i <= 10; $i++) {
            $siswa = new Siswa();
            $random = rand(1111111111,9999999999);
            $siswa["NIS"] = $random;
            $siswa["email"] = $random . "@akademis.com";
            $siswa["name"] = "akademis-" . $random;
            $siswa["address"] = "alamat " . $random;
            $siswa["dateJoin"] = Carbon::now();
            array_push($data, $siswa);
        }
        return view('admin.siswa', ["siswas" => $data]);
    }
}
