<?php

namespace App\Http\Controllers;

use App\Traits\NumberTraits;
use PDF;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    use NumberTraits;

    public function printPdf($idMurid, $tglBayar)
    {
        $total = DB::table('total_pembayaran')->where('id_murid', $idMurid)
            ->where('tanggal_bayar', $tglBayar)->first();
        $nis = $total->nomor_induk_siswa;
        $studentName = $total->nama_murid;
        $paymentMethod = $total->metode_pembayaran;
        $unitName = '';
        $className = '';
        $adjusmentAmount = 0;
        $total = $total->total_akhir;
        $subTotal = 0;

        $detailPembayaran = DB::table('detail_pembayaran')->where('id_murid', $idMurid)
            ->where('tanggal_bayar', $tglBayar)->get();
        if (!empty($detailPembayaran)) {
            $unitName = $detailPembayaran[0]->nama_unit;
            $className = $detailPembayaran[0]->kelas;
            $adjusmentAmount = $detailPembayaran[0]->potongan;
            $subTotal = $total + $adjusmentAmount;
        }

        PDF::setOptions(['debugCss' => true]);
        $pdf = PDF::loadView('layouts.print_pdf', [
            'payments' => $detailPembayaran,
            'nis' => $nis,
            'paymentMethod' => $paymentMethod,
            'studentName' => $studentName,
            'unitName' => $unitName,
            'className' => $className,
            'adjusmentAmount' => $adjusmentAmount,
            'total' => $total,
            'subTotal' => $subTotal,
            'tglBayar' => $tglBayar,
            'terbilang' => ucwords($this->terbilang($total))
        ]);
        return $pdf->stream();
//        return view('layouts.print_pdf', [
//            'payments' => $detailPembayaran,
//            'nis' => $nis,
//            'paymentMethod' => $paymentMethod,
//            'studentName' => $studentName,
//            'unitName' => $unitName,
//            'className' => $className,
//            'adjusmentAmount' => $adjusmentAmount,
//            'total' => $total,
//            'subTotal' => $subTotal
//        ]);
    }
}
