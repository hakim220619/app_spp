<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Toast extends Component
{
    protected $listeners = ['show-toast' => 'setToast'];
    public $alertTypeClasses = [
        'success' => 'bg-success',
        'warning' => 'bg-warning',
        'error' => 'bg-danger',
    ];

    public $message = '';
    public $alertType = 'success';

    public function setToast ($message, $alertType)
    {
        $this->message = $message;
        $this->alertType = $alertType;
        $this->dispatchBrowserEvent('toast-message-show');
    }

    public function render()
    {
        return view('livewire.toast');
    }
}
