<?php

namespace App\Traits;

use App\Models\Views\ViewTotalPayments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait ViewTotalTraits
{
    public function generateDataTotal($studentId = null)
    {
        return ViewTotalPayments::where(function ($query) {
            if ($this->search['date']) {
                $splitDate = explode(' s/d ', $this->search['date']);
                $startDate = Carbon::parse($splitDate[0])->format('Y-m-d');
                $endDate = Carbon::parse($splitDate[1])->format('Y-m-d');
                $query->WhereBetween(DB::raw('cast(tanggal_bayar as date)'), [$startDate, $endDate]);
            }
            if (isset($this->search['method']) && $this->search['method']) {
                $query->Where('metode_pembayaran', $this->search['method']);
            }
        })->where(function ($query) {
            if (isset($this->search['studentName']) && $this->search['studentName'] != "") {
                $query->where('nama_murid', 'like', '%' . $this->search['studentName'] . '%');
                $query->orWhere('nomor_induk_siswa', 'like', '%' . $this->search['studentName'] . '%');
            }
        })->where(function ($query) use ($studentId) {
            if ($studentId) {
                $query->where("id_murid", $studentId);
            }
        })
            ->orderBy('tanggal_bayar', 'desc')
            ->paginate($this->perPage);
    }
}
