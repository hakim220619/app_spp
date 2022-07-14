<?php

namespace App\Http\Controllers;

use App\Models\Master\Siswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    private $color = [
        '#fe8688',
        '#de86fe',
        '#9e86fe',
        '#8698fe',
        '#86bafe',
        '#86e2fe',
        '#86fef8',
        '#86fedc',
        '#86fec6',
        '#86fea4',
        '#b8fe86',
        '#dafe86',
        '#f2fe86',
        '#feee86',
        '#fed086',
        '#febc86',
    ];


    public function index()
    {
        $totalSiswa = Siswa::all()->toArray();
        $totalSiswaPria = array_filter($totalSiswa, function ($var) {
            return $var['gender'] === "L";
        });
        $totalSiswaWanita = array_filter($totalSiswa, function ($var) {
            return $var['gender'] === "P";
        });
        for ($m = 1; $m <= 12; $m++) {
            $months[] = Carbon::create()->now()->day(1)->month($m)->format("F");
        }

        $dataSpp = DB::table("jumlah_spp")->get();
        $dataSetsSpp = [];
        for ($i = 0; $i < count($dataSpp); $i++) {
            $spp = $dataSpp[$i];
            $dataSetsSpp[$i]['label'] = $spp->kelas . " - " . $spp->unit;
            $dataSetsSpp[$i]['data'] = [
                $spp->january,
                $spp->febuary,
                $spp->maret,
                $spp->april,
                $spp->mei,
                $spp->juni,
                $spp->july,
                $spp->agustus,
                $spp->september,
                $spp->oktober,
                $spp->november,
                $spp->desember
            ];
            $dataSetsSpp[$i]['backgroundColor'] = $this->color[$i];
        }

        $dataGroupingSiswa = DB::table("jumlah_siswa")->get();
        $labelSiswa = ["Laki=laki", 'Perempuan'];
        $counterColor = count($this->color) - 1;
        $dataSetsJumlahSiswa = [];
        for ($i = 0; $i < count($dataGroupingSiswa); $i++) {
            $siswa = $dataGroupingSiswa[$i];
            $dataSetsJumlahSiswa[$i]['label'] = $siswa->unit . " - " . $siswa->kelas;
            $dataSetsJumlahSiswa[$i]['backgroundColor'] = $this->color[$counterColor--];
            $dataSetsJumlahSiswa[$i]['data'][0] = $siswa->laki;
            $dataSetsJumlahSiswa[$i]['data'][1] = $siswa->perempuan;
        }

        return view("admin.dashboard", [
            'totalSiswa' => $totalSiswa,
            'totalSiswaPria' => $totalSiswaPria,
            'totalSiswaWanita' => $totalSiswaWanita,
            'months' => $months,
            'dataSetsSpp' => $dataSetsSpp,
            'labelSiswa' => $labelSiswa,
            'dataSetJumlahSiswa' => $dataSetsJumlahSiswa,
            'titleTotalSpp' => "Total Sudah Bayar SPP " . date("Y") . " - " . (date("Y") + 1)
        ]);
    }
}
