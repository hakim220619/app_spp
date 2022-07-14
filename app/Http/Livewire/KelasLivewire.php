<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Abstracts\Datatables;
use App\Models\Master\Kelas;
use App\Models\Master\Unit;

class KelasLivewire extends Datatables
{
    public $idKelas;
    public $dataUnit;
    public $dataGrades;
    public $unitName;

    protected $rules = [
        'unitName' => 'required',
        'object.name' => 'required',
        'object.unit_id' => 'required',
        'object.majors' => ''
    ];

    protected $messages = [
        'unitName.required' => 'Unit harus dipilih',
        'object.name.required' => 'Nama harus diisi',
        'object.name.unique' => 'Nama sudah digunakan',
        'object.unit_id.required' => 'Unit harus dipilih'
    ];

    public function mount()
    {
        parent::mount();
        $this->object = new Kelas();
        $this->strObject = 'App\Models\Master\Kelas';
        $this->dataGrades = [];
        $this->dataUnit = collect(Unit::select('name')->groupBy('name')->get());
    }

    private function generateDatas()
    {
        return $this->object::where(function ($query) {
            if ($this->searchTerm != "") {
                $query->where('class.name', 'like', '%' . $this->searchTerm . '%');
            }
        })
            ->select(['class.*', 'unit.name as unitName', 'unit.grade as unitGrade'])
            ->join('unit', 'class.unit_id', '=', 'unit.id')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.kelas-livewire', [
            'datas' => $this->generateDatas(),
        ]);
    }

    public function updatedUnitName()
    {
        $this->dataGrades = Unit::where('name', $this->unitName)->get();
    }

    public function handleAdd()
    {
        $this->title = "Tambah Data Kelas";
        $this->titleButton = config('constants.buttonTitle.save');
        $this->emit(config('constants.modal.open'));
    }

    public function handleEdit($kelas)
    {
        $this->unitName = $kelas['unitName'];
        $this->dataGrades = Unit::where('name', $this->unitName)->get();
        $this->idKelas = $kelas['id'];
        $this->object->unit_id = $kelas['unit_id'];
        $this->object->name = $kelas['name'];
        $this->title = "Ubah Data Kelas";
        $this->titleButton = config('constants.buttonTitle.edit');
        $this->emit(config('constants.modal.open'));
    }

    public function handleDelete(Kelas $kelas)
    {
        $this->object = $kelas;
        $this->title = "Hapus Data Kelas";
        $this->titleButton = config('constants.buttonTitle.delete');
        $this->emit(config('constants.modal.open'));
    }

    public function handleCloseModal()
    {
        $this->resetValidation();
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
    }

    public function save()
    {
        $this->validate();
        if ($this->customValidate()) return;
        $this->object->save();
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
        $this->emit('show-toast', 'Simpan Data Berhasil', 'success');
    }

    public function edit()
    {
        $this->validate();
        if ($this->customValidate()) return;
        Kelas::where('id', $this->idKelas)
            ->update(['name' => $this->object->name, 'unit_id' => $this->object->unit_id]);
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
        $this->emit('show-toast', 'Ubah Data Berhasil', 'success');
    }

    public function delete()
    {
        $this->object->delete();
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
        $this->emit('show-toast', 'Hapus Data Berhasil', 'success');
    }

    public function customValidate(): bool
    {
        $kelas = Kelas::where('unit_id', $this->object->unit_id)
            ->where('name', $this->object->name)
            ->get()->toArray();
        if (count($kelas) > 0) {
            $this->addError('object.unit_id', "Unit sudah digunakan");
            $this->addError('object.name', "Nama sudah digunakan");
            return true;
        }
        return false;
    }

    public function resetObject()
    {
        $this->object = new Kelas();
        $this->idKelas = '';
        $this->unitName = '';
    }
}
