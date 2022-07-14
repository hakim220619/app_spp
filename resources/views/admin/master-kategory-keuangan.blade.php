@extends('adminlte::page')

@section('card-body')
    @livewire('kategory-keuangan-livewire')
@stop

{{--@section('content_header')--}}
{{--    <h3>Master Kategory Keuangan</h3>--}}
{{--    <button type="button" class="btn btn-primary" data-toggle="modal" data-toggles="tooltip"--}}
{{--            data-target="#kategoryKeuanganModal" data-type="add">--}}
{{--        <i class="fas fa-fw fa-plus"></i> Tambah Data--}}
{{--    </button>--}}
{{--@endsection--}}

{{--@section('content')--}}
{{--    <table id="table_id" class="table table-striped table-bordered">--}}
{{--        <thead>--}}
{{--        <tr>--}}
{{--            <th>Name</th>--}}
{{--            <th>Action</th>--}}
{{--        </tr>--}}
{{--        </thead>--}}
{{--        <tbody>--}}
{{--        @foreach($kategoryKeuangans as $kategoryKeuangan)--}}
{{--            <tr>--}}
{{--                <td>{{$kategoryKeuangan['name']}}</td>--}}
{{--                <td>--}}
{{--                    <button class="btn btn-primary" data-kategory-keuangan="{{$kategoryKeuangan}}" data-toggle="modal"--}}
{{--                            data-target="#kategoryKeuanganModal"--}}
{{--                            data-toggles="tooltip" data-placement="bottom"--}}
{{--                            title="Ubah Data" data-type="edit"><i class="fas fa-fw fa-edit"></i></button>--}}
{{--                    <button class="btn btn-danger" data-kategory-keuangan="{{$kategoryKeuangan}}" data-toggle="modal"--}}
{{--                            data-target="#kategoryKeuanganModal"--}}
{{--                            data-toggles="tooltip" data-placement="bottom"--}}
{{--                            title="Hapus Data" data-type="delete"><i class="fas fa-fw fa-trash"></i>--}}
{{--                    </button>--}}
{{--                </td>--}}
{{--            </tr>--}}
{{--        @endforeach--}}
{{--    </table>--}}
{{--@endsection--}}

{{--@section('modal_id', 'kategoryKeuanganModal')--}}

{{--@section('modal_body')--}}
{{--    <div id="formKategoryKeuangan">--}}
{{--        <input type="hidden" id="inputType"/>--}}
{{--        <div class="form-group">--}}
{{--            <label for="inputName">Nama</label>--}}
{{--            <input type="text" class="form-control" id="inputName" name="NIS" placeholder="SPP">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div id="deleteKategoryKeuangan">--}}
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

{{--        $('#kategoryKeuanganModal').on('show.bs.modal', function (event) {--}}
{{--            var button = $(event.relatedTarget);--}}
{{--            var type = button.data('type');--}}
{{--            var kategoryKeuangan = button.data('kategory-keuangan');--}}
{{--            var modal = $(this)--}}
{{--            $("#formKategoryKeuangan").show();--}}
{{--            $("#deleteKategoryKeuangan").hide();--}}
{{--            $("#inputType").val(type);--}}
{{--            if (type === 'add') {--}}
{{--                modal.find('.modal-title').text('Tambah Data Kategory Keuangan')--}}
{{--                modal.find('#inputName').val('');--}}
{{--            } else if (type === 'edit') {--}}
{{--                modal.find('.modal-title').text('Ubah Data Kategory Keuangan')--}}
{{--                modal.find('#inputName').val(kategoryKeuangan.name);--}}
{{--            } else if (type === 'delete') {--}}
{{--                $("#formKategoryKeuangan").hide();--}}
{{--                $("#deleteKategoryKeuangan").show();--}}
{{--                modal.find('.modal-title').text('Hapus Data Kategory Keuangan')--}}
{{--                modal.find('#delete-title').text(`Anda yakin menghapus kategory ${kategoryKeuangan.name}`)--}}
{{--            }--}}
{{--        });--}}

{{--        $('#save').on('click', function () {--}}
{{--            console.log("ASD")--}}
{{--            $('#kategoryKeuanganModal').modal('hide');--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
