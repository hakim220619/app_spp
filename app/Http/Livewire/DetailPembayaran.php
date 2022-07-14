<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DetailPembayaran extends Component
{
    public $detailPayments;
    public $idMurid;
    public $tglBayar;
    public $nis;
    public $studentName;
    public $paymentMethod;
    public $adjusmentAmount;
    public $subTotal;
    public $total;
    public $className;
    public $unitName;
    public $isAdmin;

    protected $listeners = ['openDetailModal'];

    public function openDetailModal($data, $isAdmin)
    {
        $tmpData = json_decode($data, true);
        $this->idMurid = $tmpData['id_murid'];
        $this->tglBayar = $tmpData['tanggal_bayar'];
        $this->nis = $tmpData['nomor_induk_siswa'];
        $this->studentName = $tmpData['nama_murid'];
        $this->paymentMethod = $tmpData['metode_pembayaran'];
        $this->total = 0;
        $this->subTotal = 0;
        $this->detailPayments = DB::table('detail_pembayaran')->where('id_murid', $tmpData['id_murid'])
            ->where('tanggal_bayar', $tmpData['tanggal_bayar'])->get();
        if (!empty($this->detailPayments)) {
            $this->unitName = $this->detailPayments[0]->nama_unit;
            $this->className = $this->detailPayments[0]->kelas;
            $this->adjusmentAmount = $this->detailPayments[0]->potongan;
            $this->total = $tmpData['total_akhir'];
            $this->subTotal = $this->total + $this->adjusmentAmount;
        }
        $this->isAdmin = $isAdmin;
        $this->emit(config('constants.modal.open'), 'detailModal');
    }

    public function render()
    {
        return view('livewire.detail-pembayaran');
    }
}
