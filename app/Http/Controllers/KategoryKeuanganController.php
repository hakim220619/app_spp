<?php

namespace App\Http\Controllers;

use App\Models\Master\KategoryKeuangan;

class KategoryKeuanganController extends Controller
{
    public function index()
    {
        $data = [];
        $kategoryKeuangan = new KategoryKeuangan();
        $kategoryKeuangan["name"] = 'SPP';
        array_push($data, $kategoryKeuangan);
        return view('admin.kategory-keuangan', ["kategoryKeuangans" => $data]);
    }
}
