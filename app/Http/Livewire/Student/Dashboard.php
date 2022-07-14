<?php

namespace App\Http\Livewire\Student;

use App\Models\Master\Siswa;
use Livewire\Component;

class Dashboard extends Component
{
    public $studentName;

    public function mount()
    {
        $this->studentName = Siswa::where('email', auth()->user()->email)->first()->name;
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
