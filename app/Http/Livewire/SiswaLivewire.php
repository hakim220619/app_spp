<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Abstracts\Datatables;
use App\Imports\SiswaImport;
use App\Models\Master\Kelas;
use App\Models\Master\Siswa;
use App\Models\Master\Unit;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class SiswaLivewire extends Datatables
{
    use WithFileUploads;

    public $unitName = '';
    public $dataUnit = [];
    public $dataKelas = [];
    public $dataStatus = [];
    public $dataGrades = [];
    public $file;

    protected function rules()
    {
        return [
            'unitName' => 'required',
            'object.nis' => 'required|unique:student,nis,NULL|numeric|digits_between:5,20',
            'object.name' => 'required',
            'object.email' => 'required',
            'object.gender' => 'required',
            'object.phone' => 'required|digits_between:10,14',
            'object.date_of_birth' => 'required',
            'object.unit_id' => 'required',
            'object.class_id' => 'required',
            'object.status' => 'required',
            'object.description' => ''
        ];
    }

    protected $messages = [
        'unitName.required' => 'Unit Harus dipilih',
        'object.nis.required' => 'NIS harus diisi',
        'object.nis.unique' => 'NIS sudah digunakan',
        'object.nis.digits_between' => 'NIS minimal 5 digit dan maximal 20 digit',
        'object.nis.numeric' => 'NIS harus angka',
        'object.name.required' => 'Nama harus diisi',
        'object.email.required' => 'Email harus diisi',
        'object.gender.required' => 'Jenis kelamin harus dipilih',
        'object.phone.required' => 'Nomor Whatsapp harus diisi',
        'object.phone.numeric' => 'Nomor Whatsapp harus angka',
        'object.phone.digits_between' => 'Nomor Whatsapp minimal 10 digit dan maximal 14 digit',
        'object.date_of_birth.required' => 'tanggal lahir harus diisi',
        'object.unit_id.required' => 'Kelas harus dipilih',
        'object.class_id.required' => 'Kelas harus dipilih',
        'object.status.required' => 'Status harus dipilih',
    ];

    public function mount()
    {
        parent::mount();
        $this->object = new Siswa();
        $this->strObject = 'App\Models\Master\Siswa';
        $this->dataStatus = config('constants.statusList');
        $this->dataUnit = collect(Unit::select('name')->groupBy('name')->get());
    }

    private function generateDatas()
    {
        return $this->object::where(function ($query) {
            if ($this->searchTerm != "") {
                $query->where('student.name', 'like', '%' . $this->searchTerm . '%');
                $query->orWhere('phone', 'like', '%' . $this->searchTerm . '%');
                $query->orWhere('nis', 'like', '%' . $this->searchTerm . '%');
            }
        })
            ->select(['student.*', DB::raw('concat(unit.name,"-", unit.grade) as unitName'), 'class.name as className'])
            ->leftJoin('unit', 'student.unit_id', 'unit.id')
            ->leftJoin('class', 'student.class_id', 'class.id')
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.siswa-livewire', [
            'datas' => $this->generateDatas(),
        ]);
    }

    public function handleCloseModal()
    {
        $this->resetObject();
        $this->unitName = '';
        $this->resetValidation();
        $this->emit(config('constants.modal.close'));
    }

    public function handleAdd()
    {
        $this->title = "Tambah Data Siswa";
        $this->titleButton = config('constants.buttonTitle.save');
        $this->emit(config('constants.modal.open'));
    }

    public function handleEdit(Siswa $siswa)
    {
        $this->object = $siswa;
        $this->unitName = Unit::where('id', $siswa->unit_id)->first()->name;
        $this->updatedUnitName();
        $this->title = "Ubah Data Siswa";
        $this->dataKelas = Kelas::where('unit_id', $this->object->unit_id)->get();
        $this->titleButton = config('constants.buttonTitle.edit');
        $this->emit(config('constants.modal.open'));
    }

    public function handleDelete(Siswa $siswa)
    {
        $this->object = $siswa;
        $this->title = "Hapus Data Siswa";
        $this->titleButton = config('constants.buttonTitle.delete');
        $this->emit(config('constants.modal.open'));
    }

    public function save()
    {
        $this->validate();
        try {
            DB::beginTransaction();
            $this->object->year = date('Y');
            $this->object->description = null;
            $this->object->save();
            $user = new User();
            $user->email = $this->object->email;
            $user->password = Hash::make($this->object->nis);
            $user->role_id = 3;
            $user->save();
            DB::commit();
            $this->resetObject();
            $this->emit(config('constants.modal.close'));
            $this->emit('show-toast', 'Simpan Data Berhasil', 'success');
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

    public function edit()
    {
        $this->validate([
            'object.nis' => 'required|unique:student,nis,' . $this->object->id . '|numeric|digits:13',
            'object.name' => 'required',
            'object.email' => 'required',
            'object.gender' => 'required',
            'object.phone' => 'required',
            'object.date_of_birth' => 'required',
            'object.unit_id' => 'required',
            'object.class_id' => 'required',
            'object.status' => 'required',
            'object.description' => ''
        ]);
        try {
            $this->object->update();
            $this->resetObject();
            $this->emit('show-toast', 'Ubah Data Berhasil', 'success');
            $this->emit(config('constants.modal.close'));
        } catch (\Exception $e) {
            if (config('app.env') === 'dev') {
                dd($e);
                $this->emit('show-toast', $e->getMessage(), 'error');
            } else {
                $this->emit('show-toast', 'Terjadi kesalahan simpan data', 'error');
            }
        }
    }

    public function delete()
    {
        try {
            DB::beginTransaction();
            $user = User::where('email', $this->object->email)->first();
            $user->delete();
            $this->object->delete();
            DB::commit();
            $this->resetObject();
            $this->emit(config('constants.modal.close'));
            $this->emit('show-toast', 'Hapus Data Berhasil', 'success');
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

    public function updatedUnitName()
    {
        $this->dataGrades = Unit::where('name', $this->unitName)->get();
    }

    public function updatedObjectUnitId()
    {
        $this->dataKelas = Kelas::where('unit_id', $this->object->unit_id)->get();
    }

    public function clickUpgradeClass()
    {
        $this->emit(config('constants.modal.open'), 'upgrade');
    }

    public function clickNoUpgradeClass()
    {
        $this->emit(config('constants.modal.close'), 'upgrade');
    }

    public function handleUpgradeClass()
    {
        DB::select("CALL proc_naik_kelas() ");
        $this->clickNoUpgradeClass();
    }

    public function handleDownload()
    {
        $filename = 'example.xlsx';
        $path = public_path('file/' . $filename);
        return response()->download($path, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'inline; filename=' . $filename
        ]);
    }

    public function handleCloseUpload()
    {
        $this->file = "";
        $this->resetValidation(['file']);
        $this->emit(config('constants.modal.close'), 'import');
    }

    public function handleImport()
    {
        $this->validate(
            [
                'file' => 'required|mimes:xlsx,xls'
            ],
            [
                'file.required' => 'File harus dipilih',
                'file.mimes' => 'Format file harus XLSX atau XLS'
            ]
        );
        Excel::import(new SiswaImport, $this->file);
        $this->handleCloseUpload();
        $this->emit('show-toast', 'Upload Data Berhasil', 'success');
    }
}
