{{--@if($errors->any())--}}
{{--    {{dd($errors)}}--}}
{{--@endif--}}

<div class="card-body">
    {{-- Content Header --}}
    <div class="card-header">
        <div>
            <h3>Master Unit</h3>
{{--            <button type="button" class="btn btn-primary" data-toggles="tooltip" wire:click="handleAdd">--}}
{{--                <i class="fas fa-fw fa-plus"></i> Tambah Data--}}
{{--            </button>--}}
        </div>
    </div>

    {{-- Main Content --}}
    <div class="card-body table-responsive content">
        <div class="container">
            <div class="row">
                <div class="form-group row align-baseline col-md-2">
                    <label for="inputName" class="col-sm-6 mt-1">Per Page</label>
                    <div class="col-sm-6">
                        <select class="form-control" wire:model="perPage">
                            @foreach($perPageList as $page)
                                <option value="{{$page}}">{{$page}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group col-md-4 offset-md-6">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama"
                           wire:model.debounce.300ms="searchTerm">
                </div>
            </div>
        </div>
        <div>
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Nama</th>
                    <th>Grade</th>
                    <th>Tanggal Dibuat</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($datas) > 0)
                    @foreach($datas as $data)
                        <tr>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['grade']}}</td>
                            <td>{{$data['created_at']}}</td>
                            <td>
                                <button class="btn btn-primary" data-toggles="tooltip" data-placement="bottom"
                                        title="Ubah Data" wire:click="handleEdit({{$data}})"><i
                                        class="fas fa-fw fa-edit"></i></button>
{{--                                <button class="btn btn-danger" data-toggles="tooltip" data-placement="bottom"--}}
{{--                                        title="Hapus Data" wire:click="handleDelete({{$data}})"><i--}}
{{--                                        class="fas fa-fw fa-trash"></i>--}}
{{--                                </button>--}}
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td align="center" colspan="4">{{config('constants.info.dataNotFound')}}</td>
                    </tr>
                @endif
            </table>
            {{ $datas->links('paginate-view') }}
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="handleCloseModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($titleButton == config('constants.buttonTitle.save'))
                        <div id="formUnit">
                            <div class="form-group">
                                <label for="inputName">Nama</label>
                                <input type="text" class="form-control" id="inputName" name="name" placeholder="SD"
                                       wire:model="name" autocomplete="off">
                                @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                            </div>
                            @foreach($grades as $index => $grade)
                                <div class="form-group">
                                    <label for="inputName">Grade</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control flex-fill mr-2"
                                               id="inputIdGrade.{{$index}}"
                                               name="inputGrade[{{$index}}]"
                                               placeholder="1"
                                               wire:model="grades.{{$index}}" autocomplete="off">
                                        <button wire:click="handleDeleteCategory({{$index}})" type="button"
                                                class="btn btn-danger">
                                            <i class="fas fa-fw fa-minus"></i>
                                        </button>
                                    </div>
                                    @error('grades.'.$index) <span
                                        class="text-danger error">{{ $message }}</span>@enderror
                                </div>
                            @endforeach
                            <div class="form-groupr">
                                <button wire:click="handleAddGrade" type="button" class="btn btn-primary">
                                    Tambah Grade
                                </button>
                            </div>
                        </div>
                    @elseif($titleButton == config('constants.buttonTitle.edit'))
                        <div class="form-group">
                            <label for="inputName">Nama</label>
                            <input type="text" class="form-control" name="name" placeholder="SD"
                                   wire:model="name" autocomplete="off">
                            @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label for="inputName">Grade</label>
                            <input type="text" class="form-control"
                                   id="inputIdGrade"
                                   name="inputGrade"
                                   placeholder="1"
                                   wire:model="grade" autocomplete="off"/>
                            @error('grade') <span
                                class="text-danger error">{{ $message }}</span>@enderror
                        </div>
                    @else
                        <div id="deleteUnit">
                            <p id="delete-title">Apakah anda yakin ingin menghapus unit <b>{{$object->name}}</b></p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            wire:click="handleCloseModal">{{config('constants.buttonTitle.close')}}</button>
                    @if($titleButton == config('constants.buttonTitle.save'))
                        <button wire:click="save" id="save" type="button"
                                class="btn btn-primary">{{config('constants.buttonTitle.save')}}
                        </button>
                    @elseif($titleButton == config('constants.buttonTitle.edit'))
                        <button wire:click="edit" id="save" type="button"
                                class="btn btn-primary">{{config('constants.buttonTitle.edit')}}
                        </button>
                    @else
                        <button wire:click="delete" id="save" type="button"
                                class="btn btn-primary">{{config('constants.buttonTitle.delete')}}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
