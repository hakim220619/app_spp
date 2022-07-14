<?php

namespace App\Http\Livewire;

use App\Helper\NumberHelper;
use App\Models\Master\KategoryKeuangan;
use App\Models\Master\Kelas;
use App\Models\Master\Pembayaran;
use App\Models\Master\Siswa;
use App\Models\Master\Unit;
use App\Traits\PaymentTraits;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class AddPembayaran extends Component
{
    use PaymentTraits;
    public $unitName;
    public $className;
    public $flagStudent;
    public $dataCategoryPayment;
    public $dataSearchStudent = [];
    public $dataMethodPayment = [];
    public $months = [];
    public $flagEdit = false;

    protected $listeners = ['edit'];

    private $payment = [
        'category_payment_id' => null,
        'type' => '',
        'months' => [],
        'amount' => 0,
        'total_amount' => 0,
        'year' => '',
        'selectedBefore' => ''
    ];

    public $addPayment = [
        'student' => null,
        'categoryPayments' => [],
        'grand_total' => 0,
        'adjustment_amount' => null,
        'payment_method' => '',
        'total' => 0
    ];

    protected $rules = [
        'addPayment.student.name' => 'required',
        'addPayment.payment_method' => 'required',
        'addPayment.categoryPayments.*.category_payment_id' => 'required',
        'addPayment.categoryPayments.*.months' => 'required_if:addPayment.categoryPayments.*.type,==,Perbulan',
        'addPayment.categoryPayments.*.year' => 'required',
        'addPayment.total' => ''
    ];

    protected $messages = [
        'addPayment.student.name.required' => 'Nama murid harus diisi',
        'addPayment.payment_method.required' => 'Metode pembayaran harus dipilih',
        'addPayment.categoryPayments.required' => 'test',
        'addPayment.categoryPayments.*.category_payment_id.required' => 'Kategori harus dipilih',
        'addPayment.categoryPayments.*.months.required' => 'Bulan harus dipilih',
        'addPayment.categoryPayments.*.year.required' => 'Tahun harus dipilih',
    ];

    public function edit($data)
    {
        $tmpData = json_decode($data, true);
        $siswa = Siswa::where('id', $tmpData['id_murid'])->first();
        $this->handleClickSearch($siswa);
        $this->addPayment['payment_method'] = $tmpData['metode_pembayaran'];
        $detail = DB::table('detail_pembayaran')->where('id_murid', $tmpData['id_murid'])
            ->where('tanggal_bayar', $tmpData['tanggal_bayar'])->get();
        $potongan = 0;
        $grandTotal = 0;
        foreach ($detail as $key => $val) {
            $payment = [
                'id' => null,
                'category_payment_id' => null,
                'type' => '',
                'months' => [],
                'amount' => 0,
                'total_amount' => 0,
                'year' => '',
                'selectedBefore' => ''
            ];

            $pembayaran = Pembayaran::where("id", $val->id_pembayaran)->first();
            $payment['id'] = $pembayaran->id;
            $payment['category_payment_id'] = $pembayaran->category_payment_id;
            $payment['type'] = $val->tipe_pembayaran;
            if ($val->tipe_pembayaran == "Perbulan") {
                $splitDesc = explode(" - ", $val->deskripsi);
                $payment['months'] = explode(', ', $splitDesc[1]);
                $payment['amount'] = $val->nominal_bayar / count($payment['months']);
                $payment['year'] = $splitDesc[0];
            } else if ($val->tipe_pembayaran == "Pertahun") {
                $payment['amount'] = $val->nominal_bayar;
                $payment['year'] = $val->deskripsi;
            }
            $payment['total_amount'] = $val->nominal_bayar;
            $this->addPayment['categoryPayments'][$key] = $payment;
            $potongan = NumberHelper::castCurrency(intval($val->potongan));
            $grandTotal += $payment['total_amount'];
        }
        $this->addPayment['adjustment_amount'] = NumberHelper::numberFormat($potongan);
        $this->addPayment['grand_total'] = $grandTotal;
        $this->addPayment['total'] = $grandTotal - $potongan;
        $this->flagEdit = true;
        $this->emit(config('constants.modal.open'));
    }

    public function mount($methodPayment)
    {
        $this->dataMethodPayment = $methodPayment;
        $this->addPayment['student'] = new Siswa;
        $this->addPayment['categoryPayments'] = [$this->payment];
        $this->flagStudent = false;
        $i = 7;
        for ($m = 1; $m <= 12; $m++) {
            $this->months[] = Carbon::create()->now()->day(1)->month($i)->format("M");
            $i++;
        }
    }

    public function render()
    {
        return view('livewire.add-pembayaran');
    }

    public function handleClickSearch(Siswa $siswa)
    {
        $this->unitName = Unit::where('id', $siswa->unit_id)->select(DB::raw("concat(name, '-', grade) as name"))->first()->name;
        $this->className = Kelas::where('id', $siswa->class_id)->first()->name;
        $this->dataCategoryPayment = KategoryKeuangan::where('class_id', $siswa->class_id)->get();
        $this->addPayment['student'] = $siswa;
        $this->dataSearchStudent = [];
        $this->flagStudent = true;
    }

    public function updatedAddPaymentStudentName()
    {
        $this->dataSearchStudent = Siswa::where('name', 'like', '%' . $this->addPayment['student']['name'] . '%')
            ->orWhere('nis', 'like', '%' . $this->addPayment['student']['name'] . '%')
            ->take(5)
            ->get();
    }

    public function updatedAddPaymentAdjustmentAmount()
    {
        try {
            $this->addPayment['adjustment_amount'] = preg_replace('/\D/', '', trim($this->addPayment['adjustment_amount']));
            $amount = NumberHelper::castCurrency($this->addPayment['adjustment_amount']);
            $this->addPayment['adjustment_amount'] = NumberHelper::numberFormat($amount);
            $this->calculateTotal();
        } catch (\Exception $e) {
            $this->emit('show-toast', $e->getMessage(), 'error');
        }
    }

    public function updated($fields)
    {
        if (Str::contains($fields, 'addPayment.categoryPayments')) {
            if (Str::contains($fields, 'category_payment_id')) {
                [$index, $idCategory] = $this->findIdCategoryFromArray($fields);
                if ($idCategory) {
                    $tmpKategory = KategoryKeuangan::where('id', $idCategory)->first();
                    $this->addPayment['categoryPayments'][$index]['category_payment_id'] = $tmpKategory->id;
                    $this->addPayment['categoryPayments'][$index]['type'] = $tmpKategory->type;
                    $this->addPayment['categoryPayments'][$index]['amount'] = $tmpKategory->amount;
                    $this->addPayment['categoryPayments'][$index]['months'] = [];
                    $this->addPayment['categoryPayments'][$index]['year'] = '';
                    $this->addPayment['categoryPayments'][$index]['selectedBefore'] = '';
                }
                if ($tmpKategory && strtolower($tmpKategory->type) == 'pertahun') {
                    $this->setSelectedBefore($index,
                        $this->addPayment['student']['id'],
                        $tmpKategory->id,
                        null
                    );
                }
            } else if (Str::contains($fields, 'months')) {
                [$index, $idCategory] = $this->findIdCategoryFromArray($fields);
                if ($idCategory) {
                    $this->addPayment['categoryPayments'][$index]['total_amount'] =
                        count($this->addPayment['categoryPayments'][$index]['months']) * $this->addPayment['categoryPayments'][$index]['amount'];
                }
            } else if (Str::contains($fields, 'year')) {
                [$index, $idCategory] = $this->findIdCategoryFromArray($fields);
                if ($idCategory && strtolower($this->addPayment['categoryPayments'][$index]['type']) == 'pertahun') {
                    if ($this->addPayment['categoryPayments'][$index]['year'] > 0) {
                        $this->addPayment['categoryPayments'][$index]['total_amount'] = $this->addPayment['categoryPayments'][$index]['amount'];
                    } else {
                        $this->addPayment['categoryPayments'][$index]['total_amount'] = 0;
                    }
                } else if (strtolower($this->addPayment['categoryPayments'][$index]['type']) == 'perbulan') {
                    $this->setSelectedBefore($index,
                        $this->addPayment['student']['id'],
                        $this->addPayment['categoryPayments'][$index]['category_payment_id'],
                        $this->addPayment['categoryPayments'][$index]['year']
                    );
                }
            }
            $this->calculateTotal();
        }
    }

    public function handleDeleteCategory($index)
    {
        unset($this->addPayment['categoryPayments'][$index]);
        $this->addPayment['categoryPayments'] = array_values($this->addPayment['categoryPayments']);
        $this->calculateTotal();
    }

    public function resetObject()
    {
        $this->flagEdit = false;
        $this->flagStudent = false;
        $this->addPayment = [
            'student' => null,
            'categoryPayments' => [],
            'grand_total' => 0,
            'adjustment_amount' => null,
            'payment_method' => '',
            'total' => 0,
            'disabledMonths' => [],
            'diabledYear' => []
        ];
    }

    private function findIdCategoryFromArray($fields)
    {
        $split = explode(".", $fields);
        $index = $split[2];
        $idCategory = $this->addPayment['categoryPayments'][$index]['category_payment_id'];
        return [$index, $idCategory];
    }

    private function calculateTotal()
    {
        $this->addPayment['grand_total'] = 0;
        foreach ($this->addPayment['categoryPayments'] as $categoryPayment) {
            $this->addPayment['grand_total'] += $categoryPayment['total_amount'];
        }
        $this->addPayment['total'] = $this->addPayment['grand_total'];
        if ($this->addPayment['adjustment_amount'] && $this->addPayment['adjustment_amount'] > 0) {
            $this->addPayment['total'] -= NumberHelper::castCurrency($this->addPayment['adjustment_amount']);
        }
    }

    public function handleAddCategory()
    {
        $this->addPayment['categoryPayments'][] = $this->payment;
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            foreach ($this->addPayment['categoryPayments'] as $category) {
                $payment = new Pembayaran;
                $payment->student_id = $this->addPayment['student']['id'];
                $payment->adjusment_amount = $this->addPayment['adjustment_amount'] ? NumberHelper::castCurrency($this->addPayment['adjustment_amount']) : 0;
                $payment->payment_method = $this->addPayment['payment_method'];
                switch (strtolower($category['type'])) {
                    case 'perbulan':
                        $payment->description = $category['year'] . " - " . implode(', ', $category['months']);
                        break;
                    case 'pertahun':
                        $payment->description = $category['year'];
                        break;
                    case 'perjenjang':
                        $payment->description = "Perjenjang";
                        break;
                }
                $payment->category_payment_id = $category['category_payment_id'];
                $payment->amount = intval($category['total_amount']);
                $insert[] = $payment->toArray();
            }
            Pembayaran::insert($insert);
            DB::commit();
            $this->resetObject();
            $this->emitTo('pembayaran-livewire', 'successSave');
            $this->emit('show-toast', 'Simpan Data Berhasil.', 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            if (config('app.env') === 'dev') {
                dd($e);
                $this->emit('show-toast', $e->getMessage(), 'error');
            } else {
                $this->emit('show-toast', 'Terjadi kesalahan simpan data', 'error');
            }
        }
    }

    public function handleEdit()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            foreach ($this->addPayment['categoryPayments'] as $category) {
                $payment = Pembayaran::where("id", $category['id'])->first();
                $payment->student_id = $this->addPayment['student']['id'];
                $payment->adjusment_amount = $this->addPayment['adjustment_amount'] ? NumberHelper::castCurrency($this->addPayment['adjustment_amount']) : 0;
                $payment->payment_method = $this->addPayment['payment_method'];
                switch (strtolower($category['type'])) {
                    case 'perbulan':
                        $payment->description = $category['year'] . " - " . implode(', ', $category['months']);
                        break;
                    case 'pertahun':
                        $payment->description = $category['year'];
                        break;
                    case 'perjenjang':
                        $payment->description = "Perjenjang";
                        break;
                }
                $payment->category_payment_id = $category['category_payment_id'];
                $payment->amount = intval($category['total_amount']);
                $payment->save();
            }
            DB::commit();
            $this->resetObject();
            $this->emitTo('pembayaran-livewire', 'successSave');
            $this->emit('show-toast', 'Simpan Data Berhasil.', 'success');
        } catch (\Exception $e) {
            if (config('app.env') === 'dev') {
                dd($e);
                $this->emit('show-toast', $e->getMessage(), 'error');
            } else {
                $this->emit('show-toast', 'Terjadi kesalahan simpan data', 'error');
            }
        }
    }

    public function handleCloseModal()
    {
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
    }

    private function setSelectedBefore($index, $studentId, $categoryId, $find)
    {
        $desc = $this->getPayment($studentId, $categoryId, $find);
        $this->addPayment['categoryPayments'][$index]['selectedBefore'] = $desc;
    }
}
