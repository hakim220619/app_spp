<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $password, $password_confirmation;
    public $role_id;

    protected $rules = [
        'password' => 'required|confirmed',
    ];

    public function mount()
    {
        $this->role_id = Auth::user()->role_id;
    }

    public function render()
    {
        return view('livewire.change-password');
    }

    public function changePass()
    {
        $this->validate();
        try {
            $user = Auth::user();
            $user->password = Hash::make($this->password);
            $user->update();
            $this->backPrev("Success ganti password");
        } catch (\Exception $e) {
            session()->flash('message', 'Terjadi kesalahan dalam ubah data');
        }
    }

    public function backPrev($message = null)
    {
        if ($this->role_id === 1) {
            $back = '/admin';
        } else if ($this->role_id === 2) {
            $back = '/operator';
        } else if ($this->role_id === 3) {
            $back = '/siswa';
        }

        if ($message) {
            session()->flash('message', $message);
        }
        return redirect($back);
    }
}
