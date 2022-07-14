<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Abstracts\Datatables;
use App\Http\Livewire\Interfaces\DatatablesInterface;
use App\Models\Master\Unit;
use phpDocumentor\Reflection\Types\Array_;

class UnitLivewire extends Datatables
{
    public $idUnit;
    public $name;
    public $grades;
    public $grade;

    protected $messages = [
        'name.required' => 'Nama harus diisi',
        'name.unique' => 'Nama sudah digunakan',
        'grades.*.required' => 'Grade harus diisi',
    ];

    public function mount()
    {
        parent::mount();
        $this->object = new Unit();
        $this->strObject = 'App\Models\Master\Unit';
        $this->grades[] = '';
    }

    public function render()
    {
        return view('livewire.unit-livewire', [
            'datas' => $this->generateDatas()
        ]);
    }

    private function generateDatas()
    {
        return $this->object::where(function ($query) {
            if ($this->searchTerm != "") {
                $query->where('name', 'like', '%' . $this->searchTerm . '%');
            }
        })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function handleAdd()
    {
        $this->title = "Tambah Data Unit";
        $this->titleButton = config('constants.buttonTitle.save');
        $this->emit(config('constants.modal.open'));
    }

    public function handleEdit(Unit $object)
    {
        $this->idUnit = $object->id;
        $this->name = $object->name;
        $this->grade = $object->grade;
        $this->title = "Ubah Data Unit";
        $this->titleButton = config('constants.buttonTitle.edit');
        $this->emit(config('constants.modal.open'));
    }

    public function handleDelete(Unit $object)
    {
        $this->object = $object;
        $this->title = "Hapus Data Unit";
        $this->titleButton = config('constants.buttonTitle.delete');
        $this->emit(config('constants.modal.open'));
    }

    public function handleAddGrade()
    {
        $this->grades[] = '';
    }

    public function handleDeleteCategory($index)
    {
        unset($this->grades[$index]);
        $this->grades = array_values($this->grades);
    }

    public function handleCloseModal()
    {
        $this->resetObject();
        $this->resetValidation();
        $this->emit(config('constants.modal.close'));
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|unique:unit,name',
            'grades.*' => 'required'
        ]);
        $unit = new Unit;
        $unit->name = $this->name;
        foreach ($this->grades as $grade) {
            $unit->grade = $grade;
            $insert[] = $unit->toArray();
        }
        Unit::insert($insert);
        $this->resetObject();
        $this->emit(config('constants.modal.close'));
        $this->emit('show-toast', 'Simpan Data Berhasil', 'success');
    }

    public function edit()
    {
        $this->validate([
            'name' => 'required',
            'grade' => 'required'
        ]);
        $unit = Unit::where('name', $this->name)->where('grade', $this->grade)->first();
        if ($unit) {
//            dd($unit);
            $this->addError('name', 'Nama sudah digunakan');
            $this->addError('grade', 'Grade sudah digunakan');
            return;
        }
        $this->object->id = $this->idUnit;
        Unit::where('id', $this->idUnit)
            ->update(['name' => $this->name, 'grade' => $this->grade]);
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

    public function resetObject()
    {
        $this->name = '';
        $this->grade = '';
        $this->grades = array();
        $this->grades[] = '';
    }

}
