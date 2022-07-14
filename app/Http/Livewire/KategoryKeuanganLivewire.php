<?php

namespace App\Http\Livewire;

use App\Helper\NumberHelper;
use App\Http\Livewire\Abstracts\Datatables;
use App\Http\Livewire\Interfaces\DatatablesInterface;
use App\Models\Master\KategoryKeuangan;
use App\Models\Master\Kelas;
use App\Models\Master\Unit;
use Illuminate\Support\Facades\DB;

class KategoryKeuanganLivewire extends Datatables
{
    public $kategoryId;
    public $dataTypeKeuangan = [];
    public $dataUnit = [];
    public $dataKelas = [];

    protected $rules = [
        'object.unit_id' => 'required',
        'object.class_id' => 'required',
        'object.name' => 'required',
        'object.amount' => 'required',
        'object.type' => 'required'
    ];

    protected $messages = [
        'object.unit_id.required' => 'Unit harus dipilih',
        'object.class_id.required' => 'Kelas harus dipilih',
        'object.name.required' => 'Nama harus diisi',
        'object.amount.required' => 'Nominal harus diisi',
        'object.type.required' => 'Tipe harus dipilih'
    ];

    public function mount()
    {
        parent::mount();
        $this->object = new KategoryKeuangan();
        $this->strObject = 'App\Models\Master\KategoryKeuangan';
        $this->dataTypeKeuangan = config('constants.categoryPaymentList');
        $this->dataUnit = collect(Unit::select(['id', DB::raw("concat(name, '-', grade) as name")])->get());
    }

    private function generateDatas()
    {
        return $this->object::where(function ($query) {
            if ($this->searchTerm != "") {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            }
        })
            ->select(['category_payment.*',
                'class.name as className', 'unit.id as unitId', DB::raw("concat(unit.name, '-', unit.grade) as grade")])
            ->leftJoin('class', 'category_payment.class_id', 'class.id')
            ->leftJoin('unit', 'class.unit_id', 'unit.id')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.kategory-keuangan-livewire', [
            'datas' => $this->generateDatas(),
        ]);
    }

    public function handleAdd()
    {
        $this->title = "Tambah Data Kategori Keuangan";
        $this->titleButton = config('constants.buttonTitle.save');
        $this->emit(config('constants.modal.open'));
    }

    public function handleEdit($data)
    {
        $this->kategoryId = $data['id'];
        $this->object->class_id = $data['class_id'];
        $this->object->unit_id = $data['unitId'];
        $this->object->name = $data['name'];
        $this->object->amount = NumberHelper::numberFormat($data['amount']);
        $this->object->type = $data['type'];
        $this->dataKelas = Kelas::where('unit_id', $data['unitId'])->get()->toArray();
//        $this->object = $kategoryKeuangan;
//        $this->object->amount = NumberHelper::numberFormat($kategoryKeuangan->amount);
        $this->title = "Ubah Data Kategori Keuangan";
        $this->titleButton = config('constants.buttonTitle.edit');
        $this->emit(config('constants.modal.open'));
    }

    public function handleDelete(KategoryKeuangan $kategoryKeuangan)
    {
        $this->object = $kategoryKeuangan;
        $this->title = "Hapus Data Kategori Keuangan";
        $this->titleButton = config('constants.buttonTitle.delete');
        $this->emit(config('constants.modal.open'));
    }

    public function save()
    {
        $this->validate();
        if ($this->customValidation()) return;
        try {
            $category = new KategoryKeuangan();
            $category->class_id = $this->object->class_id;
            $category->name = $this->object->name;
            $category->amount = NumberHelper::castCurrency($this->object->amount);
            $category->type = $this->object->type;
            $category->save();
            $this->resetObject();
            $this->emit(config('constants.modal.close'));
            $this->emit('show-toast', 'Simpan Data Berhasil', 'success');
        } catch (\Exception $e) {
            if (config('app.env') === 'dev') {
                $this->emit('show-toast', $e->getMessage(), 'error');
            } else {
                $this->emit('show-toast', 'Terjadi kesalahan simpan data', 'error');
            }
        }
    }

    public function edit()
    {
        $this->validate();
//        if ($this->customValidation()) return;
        try {
            $category = KategoryKeuangan::find($this->kategoryId);
            $category->id = $this->kategoryId;
            $category->class_id = $this->object->class_id;
            $category->name = $this->object->name;
            $category->amount = NumberHelper::castCurrency($this->object->amount);
            $category->type = $this->object->type;
            $category->save();
            $this->resetObject();
            $this->emit('show-toast', 'Ubah Data Berhasil', 'success');
            $this->emit(config('constants.modal.close'));
        } catch (\Exception $e) {
            if (config('app.env') === 'dev') {
                dd($e->getMessage());
                $this->emit('show-toast', $e->getMessage(), 'error');
            } else {
                $this->emit('show-toast', 'Terjadi kesalahan simpan data', 'error');
            }
        }
    }

    public function delete()
    {
        $this->object->delete();
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
        $this->emit('show-toast', 'Hapus Data Berhasil', 'success');
    }

    public function handleCloseModal()
    {
        $this->resetObject();
        $this->resetValidation();
        $this->emit(config('constants.modal.close'));
    }

    public function updatedObjectAmount()
    {
        try {
            $this->object->amount = preg_replace('/\D/', '', trim($this->object->amount));
            $amount = NumberHelper::castCurrency($this->object->amount);
            $this->object->amount = NumberHelper::numberFormat($amount);
        } catch (\Exception $e) {
            $this->emit('show-toast', $e->getMessage(), 'error');
        }
    }

    public function updatedObjectUnitId()
    {
        $this->dataKelas = Kelas::where('unit_id', $this->object->unit_id)->get()->toArray();
    }

    public function resetObject()
    {
        parent::resetObject();
        $this->kategoryId = '';
    }

    private function customValidation()
    {
        $validCategory = KategoryKeuangan::where('class_id', $this->object->class_id)
            ->where('name', $this->object->name)
            ->where('type', $this->object->type)->first();
        if ($validCategory) {
            $this->addError('object.class_id', "Kelas sudah digunakan");
            $this->addError('object.name', "Nama sudah digunakan");
            $this->addError('object.type', "Tipe sudah digunakan");
            return true;
        }
        return false;
    }

//    public function updated($field)
//    {
//        if ($field == 'object.amount') {
//            try {
//                $amount = NumberHelper::castCurrency($this->object->amount);
//                $this->object->amount = NumberHelper::numberFormat($amount);
//            } catch (\Exception $e) {
//                $this->emit('show-toast', $e->getMessage(), 'error');
//            }
//        }
//    }

}
