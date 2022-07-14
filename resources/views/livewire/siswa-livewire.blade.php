<div class="card-body">
    {{-- Content Header --}}
    <div class="card-header">
        <div>
            <h3>Master Siswa</h3>
            <button type="button" class="btn btn-primary" data-toggles="tooltip" wire:click="handleAdd">
                <i class="fas fa-fw fa-plus"></i> Tambah Data
            </button>

            <button type="button" class="btn btn-primary" data-toggles="tooltip"
                    wire:click="$emit('{{config('constants.modal.open')}}', 'import')">
                <i class="fas fa-fw fa-upload"></i> Import Data Siswa
            </button>

            <button type="button" class="btn btn-danger" data-toggles="tooltip" wire:click="clickUpgradeClass">
                <i class="fas fa-fw fa-arrow-up"></i> Naik Kelas
            </button>
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
                    <input type="text" class="form-control" placeholder="Cari berdasarkan nama / nis / nomor whatsapp"
                           wire:model.debounce.300ms="searchTerm">
                </div>
            </div>
        </div>
        <div>
            <table id="table_id" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Nomor Whatsapp</th>
                    <th>Tanggal Lahir</th>
                    <th>Tahun Ajaran</th>
                    <th>Unit</th>
                    <th>Kelas</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Dibuat</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($datas) > 0)
                    @foreach($datas as $data)
                        <tr>
                            <td>{{$data['nis']}}</td>
                            <td>{{$data['name']}}</td>
                            <td>{{$data['email']}}</td>
                            <td>{{$data['gender']}}</td>
                            <td>{{$data['phone']}}</td>
                            <td>{{date('d M Y', strtotime($data['date_of_birth']))}}</td>
                            <td>{{$data['year']}}</td>
                            <td>{{$data['unitName']}}</td>
                            <td>{{$data['className']}}</td>
                            <td>{{$data['description']}}</td>
                            <td>{{$data['created_at']}}</td>
                            <td>{{$data['status']}}</td>
                            <td>
                                <button class="btn btn-primary" data-toggles="tooltip" data-placement="bottom"
                                        title="Ubah Data" wire:click="handleEdit({{$data}})"><i
                                        class="fas fa-fw fa-edit"></i></button>
                                <button class="btn btn-danger" data-toggles="tooltip" data-placement="bottom"
                                        title="Hapus Data" wire:click="handleDelete({{$data}})"><i
                                        class="fas fa-fw fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td align="center" colspan="13">{{config('constants.info.dataNotFound')}}</td>
                    </tr>
                @endif
            </table>
            {{ $datas->links('paginate-view') }}
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$title}}</h5>
                    <button wire:click="handleCloseModal" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($titleButton == config('constants.buttonTitle.save') || $titleButton == config('constants.buttonTitle.edit'))
                        <div id="formUnit">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputNis">NIS</label>
                                            <input type="text" class="form-control" id="inputNis" name="nis"
                                                   placeholder="123456789"
                                                   autocomplete="off"
                                                   wire:model="object.nis"
                                                   @if($titleButton == config('constants.buttonTitle.edit')) disabled @endif>
                                            @error('object.nis') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Nama</label>
                                            <input type="text" class="form-control" id="inputName" name="name"
                                                   placeholder="Supri"
                                                   autocomplete="off"
                                                   wire:model="object.name">
                                            @error('object.name') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">Email</label>
                                            <input type="email" class="form-control" id="inputEmail" name="email"
                                                   placeholder="supri@gmail.com"
                                                   autocomplete="off"
                                                   wire:model="object.email">
                                            @error('object.email') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Jenis Kelamin</label>
                                            <div class="form-check">
                                                <input wire:model="object.gender" class="form-check-input" type="radio"
                                                       name="gender"
                                                       id="inputGenderMale" value="L">
                                                <label class="form-check-label" for="inputGenderMale">
                                                    Laki-laki
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input wire:model="object.gender" class="form-check-input" type="radio"
                                                       name="gender"
                                                       id="inputGenderFemale" value="P">
                                                <label class="form-check-label" for="inputGenderFemale">
                                                    Perempuan
                                                </label>
                                            </div>
                                            @error('object.gender') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPhone">Nomor Whatsapp</label>
                                            <input type="text" class="form-control" id="inputPhone" name="phone"
                                                   placeholder="081122223333"
                                                   autocomplete="off"
                                                   wire:model="object.phone">
                                            @error('object.phone') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputDateofBirth">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="inputDateofBirth" name="dob"
                                                   wire:model="object.date_of_birth">
                                            @error('object.date_of_birth') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="selectUnit">Unit</label>
                                            <select class="form-control" id="selectUnit" wire:model="unitName">
                                                <option value="">-- Pilih Satu --</option>
                                                @foreach($dataUnit as $unit)
                                                    <option value="{{$unit['name']}}">{{$unit['name']}}</option>
                                                @endforeach
                                            </select>
                                            @error('unitName') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="selectKelas">Grade / Kelas</label>
                                            <div class="d-flex flex-row">
                                                <div class="d-flex flex-column">
                                                    <select class="form-control" id="selectKelas"
                                                            wire:model="object.unit_id">
                                                        <option value="">-- Pilih Satu --</option>
                                                        @foreach($dataGrades as $grade)
                                                            <option
                                                                value="{{$grade['id']}}">{{$grade['grade']}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('object.unit_id') <span
                                                        class="text-danger error">{{ $message }}</span>@enderror
                                                </div>

                                                <div class="d-flex flex-column flex-fill">
                                                    <select class="form-control" id="selectKelas"
                                                            wire:model="object.class_id">
                                                        <option value="">-- Pilih Satu --</option>
                                                        @foreach($dataKelas as $kelas)
                                                            <option value="{{$kelas->id}}">{{$kelas->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('object.class_id') <span
                                                        class="text-danger error">{{ $message }}</span>@enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDesc">Deskripsi</label>
                                            <textarea wire:model="object.description" class="form-control"
                                                      id="inputDesc"
                                                      name="deskripsi"
                                                      placeholder="Deksripsi"
                                                      rows="3"></textarea>
                                            @error('object.description') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="selectStatus">Status</label>
                                            <select class="form-control" id="selectStatus" wire:model="object.status">
                                                <option value="">-- Pilih Satu --</option>
                                                @foreach($dataStatus as $status)
                                                    <option value="{{$status}}">{{$status}}</option>
                                                @endforeach
                                            </select>
                                            @error('object.status') <span
                                                class="text-danger error">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div id="deleteUnit">
                            <p id="delete-title">Apakah anda yakin ingin menghapus siswa <b>{{$object->name}}</b></p>
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

    <div wire:ignore.self class="modal fade" id="upgrade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Naik kelas</h5>
                </div>
                <div class="modal-body">
                    <p>Apakah anda yakin ingin melakukan process naik kelas?</p>
                    <p style="font-size: small"><b>*NB: Pastikan semua data kelas sudah diinput</b></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            wire:click="clickNoUpgradeClass"><i class="fas fw fa-ban"></i> Tidak
                    </button>
                    <button wire:click="handleUpgradeClass" id="save" type="button"
                            class="btn btn-danger"><i class="fas fw fa-check"></i> Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form>
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Excel File Siswa</h5>
                    </div>
                    <div class="modal-body">
{{--                        <div class="custom-file">--}}
{{--                            <input wire:model="file" type="file"--}}
{{--                                   class="custom-file-input @error('file') is-invalid @enderror"--}}
{{--                                   id="inputGroupFile" aria-describedby="inputGroupFileAddon">--}}
{{--                            <label class="custom-file-label" for="inputGroupFile">{{$file ? $file : "Pilih File"}}</label>--}}
{{--                            <small><b>NB* : Type file harus XLSX atau XLS</b></small>--}}
{{--                        </div>--}}
                        <div class="mb-3">
                            <input type="file" wire:model="file" style="padding-bottom: 36px" class="form-control @error('file') is-invalid @enderror" />
                            <small><b>NB* : Type file harus XLSX atau XLS</b></small>
                        </div>
                        @error('file')
                        <span class="text-danger error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <fieldset class="w-100">
                            <button type="button" class="btn btn-primary" wire:click="handleDownload"><i class="fas fw fa-download"></i> Download Contoh</button>
                            <button type="button" wire:click="handleImport" class="btn btn-primary float-right"><i class="fas fw fa-check"></i> Submit
                            </button>
                            <button type="button" class="btn btn-danger float-right mr-1"
                                    wire:click="handleCloseUpload"><i
                                    class="fas fw fa-ban"></i> Batal
                            </button>
                        </fieldset>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
