@extends('adminlte::page')

@section('card-body')
    <livewire:siswa-livewire/>
@stop

{{--@section('content_header')--}}
{{--    <h3>Master Siswa</h3>--}}
{{--    <button type="button" class="btn btn-primary" data-toggle="modal" data-toggles="tooltip"--}}
{{--            data-target="#siswaModal" data-type="add">--}}
{{--        <i class="fas fa-fw fa-plus"></i> Tambah Data--}}
{{--    </button>--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <table id="table_id" class="table table-striped table-bordered">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>NIS</th>--}}
{{--            <th>Email</th>--}}
{{--            <th>Nama</th>--}}
{{--            <th>Alamat</th>--}}
{{--            <th>Tanggal Join</th>--}}
{{--            <th>Action</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($siswas as $siswa)--}}
{{--            <tr>--}}
{{--                <td>{{$siswa['NIS']}}</td>--}}
{{--                <td>{{$siswa['email']}}</td>--}}
{{--                <td>{{$siswa['name']}}</td>--}}
{{--                <td>{{$siswa['address']}}</td>--}}
{{--                <td>{{$siswa['dateJoin']->toDateTimeString()}}</td>--}}
{{--                <td>--}}
{{--                    <button class="btn btn-primary" data-siswa="{{$siswa}}" data-toggle="modal"--}}
{{--                            data-target="#siswaModal"--}}
{{--                            data-toggles="tooltip" data-placement="bottom"--}}
{{--                            title="Ubah Data" data-type="edit"><i class="fas fa-fw fa-edit"></i></button>--}}
{{--                    <button class="btn btn-danger" data-siswa="{{$siswa}}" data-toggle="modal"--}}
{{--                            data-target="#siswaModal"--}}
{{--                            data-toggles="tooltip" data-placement="bottom"--}}
{{--                            title="Hapus Data" data-type="delete"><i class="fas fa-fw fa-trash"></i>--}}
{{--                    </button>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--@endsection--}}

{{--@section('modal_id', 'siswaModal')--}}

{{--@section('modal_body')--}}
{{--    <div id="formSiswa">--}}
{{--        <input type="hidden" id="inputType"/>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputNIS">Nomor Induk Siswa</label>--}}
{{--            <input type="text" class="form-control" id="inputNIS" name="NIS" placeholder="1234567890">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputEmail">Email</label>--}}
{{--            <input type="email" class="form-control" id="inputEmail" name="email" placeholder="akademis@akademis.com">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputName">Nama</label>--}}
{{--            <input type="text" class="form-control" id="inputName" name="name" placeholder="akademis">--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputAddress">Alamat</label>--}}
{{--            <textarea class="form-control" id="inputAddress" name="address" placeholder="Jalan Akademis"--}}
{{--                      rows="3"></textarea>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputDateJoin">Tanggal Join</label>--}}
{{--            <input type="date" class="form-control" id="inputDateJoin" name="dateJoin" placeholder="Tanggal Join">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div id="deleteSiswa">--}}
{{--        <p id="delete-title"></p>--}}
{{--    </div>--}}
{{--@stop--}}

{{--@section('modal_button')--}}
{{--    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--    <button id="save" type="button" class="btn btn-primary">Save changes</button>--}}
{{--@stop--}}


{{--@section('plugins.Datatables', true)--}}

{{--@section('js')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#table_id').DataTable();--}}
{{--        });--}}

{{--        $('#siswaModal').on('show.bs.modal', function (event) {--}}
{{--            var button = $(event.relatedTarget);--}}
{{--            var type = button.data('type');--}}
{{--            var siswa = button.data('siswa');--}}
{{--            var modal = $(this)--}}
{{--            $("#formSiswa").show();--}}
{{--            $("#deleteSiswa").hide();--}}
{{--            $("#inputType").val(type);--}}
{{--            if (type === 'add') {--}}
{{--                modal.find('.modal-title').text('Tambah Data Siswa')--}}
{{--                modal.find('#inputNIS').val('').attr("disabled", false);--}}
{{--                modal.find('#inputEmail').val('');--}}
{{--                modal.find('#inputName').val('');--}}
{{--                modal.find('#inputAddress').val('');--}}
{{--                modal.find('#inputDateJoin').val('');--}}
{{--            } else if (type === 'edit') {--}}
{{--                modal.find('.modal-title').text('Ubah Data Siswa')--}}
{{--                modal.find('#inputNIS').val(siswa.NIS).attr("disabled", true);--}}
{{--                modal.find('#inputEmail').val(siswa.email);--}}
{{--                modal.find('#inputName').val(siswa.name);--}}
{{--                modal.find('#inputAddress').val(siswa.address);--}}
{{--                modal.find('#inputDateJoin').val(formatDate(new Date(siswa.dateJoin)));--}}
{{--            } else if (type === 'delete') {--}}
{{--                $("#formSiswa").hide();--}}
{{--                $("#deleteSiswa").show();--}}
{{--                modal.find('.modal-title').text('Hapus Data Siswa')--}}
{{--                modal.find('#delete-title').text(`Anda yakin menghapus siswa ${siswa.name}`)--}}
{{--            }--}}
{{--        });--}}

{{--        $('#save').on('click', function () {--}}
{{--            console.log("ASD")--}}
{{--            $('#siswaModal').modal('hide')--}}

{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
