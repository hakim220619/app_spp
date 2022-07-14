<div class="card-body">
    {{-- Content Header --}}
    <div class="card-header">
        <h3>Pembayaran</h3>
        <button type="button" class="btn btn-primary" data-toggles="tooltip"
                wire:click="$emit('{{config('constants.modal.open')}}')">
            <i class="fas fa-fw fa-plus"></i> Tambah Data
        </button>
    </div>

    <div class="card-body table-responsive content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="inputName">Nama</label>
                        <input type="text" class="form-control" id="inputName" name="name"
                               placeholder="Cari berdasarkan nama / nis"
                               wire:model.debaunce.300ms="search.studentName" autocomplete="off">
                        {{--                        <div class="list-group position-absolute d-block w-100 pl-2 pr-2" style="left: 0; z-index: 10">--}}
                        {{--                            @foreach($dataSearchStudent as $student)--}}
                        {{--                                <a class="list-group-item list-group-item-action"--}}
                        {{--                                   wire:click="handleClickSearch('{{$student}}')">{{$student->name}}</a>--}}
                        {{--                            @endforeach--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                {{--                <div class="col-md-4">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="selectCategory">Kategori</label>--}}
                {{--                        <select id="selectCategory" class="form-control" aria-label="Default select example"--}}
                {{--                                wire:model="search.categoryPayment">--}}
                {{--                            <option value="0" selected>Cari berdasarkan kategori</option>--}}
                {{--                            @foreach($dataCategoryPayment as $pembayaran)--}}
                {{--                                <option value="{{$pembayaran["id"]}}">{{$pembayaran["name"]}}</option>--}}
                {{--                            @endforeach--}}
                {{--                        </select>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="selectMethod">Metode Pembayaran</label>
                        <select id="selectMethod" class="form-control" aria-label="Default select example"
                                wire:model="search.method">
                            <option value="0" selected>Cari berdasarkan metode pembayaran</option>
                            @foreach($dataMethodPayment as $method)
                                <option value="{{$method}}">{{$method}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="selectMethod">Cari Berdasarkan Tanggal</label>
                        <input
                            wire:model="search.date"
                            id="datepicker"
                            type="text" class="form-control datepicker"
                            autocomplete="off"
                            data-provide="datepicker" data-date-autoclose="true"
                            data-date-format="dd-mm-yyyy" data-date-today-highlight="true"
                            onchange="this.dispatchEvent(new InputEvent('input'))"
                        >
                    </div>
                </div>
                {{--                <div class="col-md-4">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="selectMethod">Status Pembayaran</label>--}}
                {{--                        <select id="selectMethod" class="form-control" aria-label="Default select example"--}}
                {{--                                wire:model="search.paymentStatus">--}}
                {{--                            <option value="0" selected>Cari berdasarkan status pembayaran</option>--}}
                {{--                            @foreach($dataPaymentStatus as $status)--}}
                {{--                                <option value="{{$status}}">{{$status}}</option>--}}
                {{--                            @endforeach--}}
                {{--                        </select>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                {{--                <div class="col-md-8">--}}
                {{--                    <div class="form-group">--}}
                {{--                        <label for="selectCategory">Bulan</label><br/>--}}
                {{--                        @foreach($months as $key => $month)--}}
                {{--                            <div class="form-check form-check-inline">--}}
                {{--                                <input class="form-check-input" type="checkbox" id="input{{$month}}"--}}
                {{--                                       value="{{$key + 1}}" wire:model="search.month">--}}
                {{--                                <label class="form-check-label" for="input{{$month}}">{{$month}}</label>--}}
                {{--                            </div>--}}
                {{--                        @endforeach--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </div>
            <div class="row">
                <div class="col-md-1">
                    <div class="form-group">
                        <label for="inputName">Per Page</label>
                        <select class="form-control" wire:model="perPage">
                            @foreach($perPageList as $page)
                                <option value="{{$page}}">{{$page}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>NIS</th>
                    <th>Nama Murid</th>
                    <th>Biaya</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Bayar</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($datas) > 0)
                    @foreach($datas as $data)
                        <tr>
                            <td>{{$data['nomor_induk_siswa']}}</td>
                            <td>{{$data['nama_murid']}}</td>
                            <td>{{"Rp ".\App\Helper\NumberHelper::numberFormat($data['total_akhir'])}}</td>
                            <td>{{$data['metode_pembayaran']}}</td>
                            <td>{{$data['tanggal_bayar']}}</td>
                            <td>
                                @if($roleId == 1)
                                    <button class="btn btn-info"
                                            wire:click="$emitTo('add-pembayaran', 'edit', '{{$data}}')">
                                        <i
                                            class="fas fa-fw fa-edit"></i>
                                        Ubah
                                    </button>
                                @endif
                                <button class="btn btn-primary"
                                        wire:click="$emitTo('detail-pembayaran', 'openDetailModal', '{{$data}}', true)">
                                    <i
                                        class="fas fa-fw fa-eye"></i>
                                    Lihat Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td align="center" colspan="6">{{config('constants.info.dataNotFound')}}</td>
                    </tr>
                @endif
            </table>
            {{ $datas->links('paginate-view') }}
        </div>
    </div>
    @livewire('add-pembayaran', ['methodPayment' => $dataMethodPayment])
    @livewire('detail-pembayaran')
    {{--    @include('admin.modal-add-pembayaran');--}}
    {{--    @include('admin.modal-detail-pembayaran')--}}
</div>

@section('plugins.JqueryUI', true)
@section('plugins.MomentJS', true)
@section('plugins.DateRangePicker', true)

@section('js')
    <script>
        document.addEventListener('livewire:load', function () {
            var dateRange = @this.search.date
            var split = dateRange.split(" s/d ");
            $("#datepicker").daterangepicker({
                startDate: split[0],
                endDate: split[1],
                locale: {
                    format: "DD-MM-YYYY",
                    separator: " s/d ",
                }
            })
        });
    </script>
@endsection
