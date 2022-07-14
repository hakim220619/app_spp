<?php

namespace App\Http\Livewire\Student;

use App\Http\Livewire\Abstracts\Datatables;
use App\Models\Master\Siswa;
use App\Traits\ViewTotalTraits;
use Carbon\Carbon;

class Transaksi extends Datatables
{
    use ViewTotalTraits;

    public $siswa;
    public $search = [
        "date" => ''
    ];

    public function mount()
    {
        parent::mount();

        $today = Carbon::now();
        $startDate = $today->firstOfMonth()->format('d-m-Y');
        $endDate = $today->endOfMonth()->format('d-m-Y');
        $this->search['date'] = $startDate . ' s/d ' . $endDate;
        $this->siswa = Siswa::where('email', auth()->user()->email)->first()->id;
    }

    public function render()
    {
        return view('livewire.student.transaksi', [
            'datas' => $this->generateDataTotal($this->siswa)
        ]);
    }
}
