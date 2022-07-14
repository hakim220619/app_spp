<div class="card-body">
    {{-- Content Header --}}
    <div class="card-header">
        <h3>Transaksi</h3>
    </div>

    <div class="card-body table-responsive content">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="datepicker">Transaksi Berdasarkan Tanggal</label>
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
                                <button class="btn btn-primary"
                                        wire:click="$emitTo('detail-pembayaran', 'openDetailModal', '{{$data}}', false)"><i
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
    @livewire('detail-pembayaran')
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
