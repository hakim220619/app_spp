<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Abstracts\Datatables;
use App\Traits\ViewTotalTraits;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PembayaranLivewire extends Datatables
{
    use ViewTotalTraits;

    public $roleId;
    public $selected = '';
    public $search = [
        'studentName' => '',
        'categoryPayment' => '',
        'method' => '',
        'paymentStatus' => '',
        'month' => [],
        'date' => ''
    ];
    public $dataMethodPayment = [];
    public $dataPaymentStatus = [];

    protected $listeners = ['successSave'];

    public function mount()
    {
        parent::mount();

        $today = Carbon::now();
        $startDate = $today->firstOfMonth()->format('d-m-Y');
        $endDate = $today->endOfMonth()->format('d-m-Y');
        $this->dataMethodPayment = config('constants.paymentMethod');
        $this->dataPaymentStatus = config('constants.paymentStatus');
        $this->search['date'] = $startDate . ' s/d ' . $endDate;
        $this->roleId = Auth::user()->role_id;
    }

    public function render()
    {
        return view('livewire.pembayaran-livewire', [
            'datas' => $this->generateDataTotal()
        ]);
    }

//    private function generateDatas()
//    {
//        return ViewTotalPayments::where(function ($query) {
//            if ($this->search['date']) {
//                $splitDate = explode(' s/d ', $this->search['date']);
//                $startDate = Carbon::parse($splitDate[0])->format('Y-m-d');
//                $endDate = Carbon::parse($splitDate[1])->format('Y-m-d');
//                $query->WhereBetween(DB::raw('cast(tanggal_bayar as date)'), [$startDate, $endDate]);
//            }
//            if ($this->search['method']) {
//                $query->Where('metode_pembayaran', $this->search['method']);
//            }
//        })->where(function ($query) {
//            if ($this->search['studentName'] != "") {
//                $query->where('nama_murid', 'like', '%' . $this->search['studentName'] . '%');
//                $query->orWhere('nomor_induk_siswa', 'like', '%' . $this->search['studentName'] . '%');
//            }
//        })->paginate($this->perPage);
//    }

    public function handleSearch()
    {
        $this->title = "Cari Data Pembayaran";
        $this->titleButton = config('constants.buttonTitle.search');
        $this->emit(config('constants.modal.open'));
    }

    public function successSave()
    {
        $this->emit(config('constants.modal.close'));
        $this->generateDataTotal();
    }

    public function print()
    {
        // TODO: Implement print() method.
    }
}
