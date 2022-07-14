<?php

namespace App\Http\Livewire\Abstracts;

use Livewire\Component;
use Livewire\WithPagination;

abstract class Datatables extends Component
{
    use WithPagination;
    // Model
    public $object;
    public $strObject;

    // Datatable attribute
    public $sortColumn;
    public $sortBy;
    public $titleButton;
    public $searchTerm;
    public $perPageList = [];
    public $perPage;
    public $title;

    public function mount()
    {
        $this->sortColumn = config('constants.sort.column');
        $this->sortBy = config('constants.sort.by');
        $this->perPageList = config('constants.paginate.options');
        $this->perPage = config('constants.paginate.default');
    }

    public function resetObject()
    {
        $this->object = new $this->strObject;
    }
}
