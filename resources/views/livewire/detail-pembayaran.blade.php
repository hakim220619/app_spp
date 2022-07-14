<div wire:ignore.self class="modal fade" id="detailModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Pembayaran</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="d-flex">
                        <div class="form-group flex-fill p-2">
                            <label class="font-weight-normal">Nama:</label>
                            <label>{{$nis}} - {{$studentName}}</label>
                        </div>
                        <div class="form-group flex-fill p-2">
                            <label class="font-weight-normal">Metode:</label>
                            <label>{{$paymentMethod}}</label>
                        </div>
                        <div class="form-group flex-fill p-2">
                            <span>Unit:</span>
                            <label>{{$unitName}}</label>
                        </div>
                        <div class="form-group flex-fill p-2">
                            <span>Kelas:</span>
                            <label>{{$className}}</label>
                        </div>
                    </div>
                    {{--                    <div class="row">--}}
                    {{--                        <div class="col-md-4">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label class="font-weight-normal">Nama:</label>--}}
                    {{--                                <label>{{$nis}} - {{$studentName}}</label>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-md-4">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <label class="font-weight-normal">Metode:</label>--}}
                    {{--                                <label>{{$paymentMethod}}</label>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-md-2">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <span>Unit:</span>--}}
                    {{--                                <label>{{$unitName}}</label>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                        <div class="col-md-2">--}}
                    {{--                            <div class="form-group">--}}
                    {{--                                <span>Kelas:</span>--}}
                    {{--                                <label>{{$className}}</label>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="row">
                        <table class="table">
                            <thead>
                            <th style="width: 25%">Kategori</th>
                            <th style="width: 50%">Bulan / Tahun</th>
                            <th class="text-right" style="width: 25%">Total</th>
                            </thead>
                            <tbody>
                            @if(!empty($detailPayments))
                                @foreach($detailPayments as $payment)
                                    <tr>
                                        <td>
                                            <label class="font-weight-normal">{{$payment->kategory_payment}}
                                                - {{$payment->tipe_pembayaran}}</label>
                                        </td>
                                        <td>
                                            <label class="font-weight-normal">{{$payment->deskripsi}}</label>
                                        </td>
                                        <td class="text-right">
                                            <label class="font-weight-normal">
                                                Rp {{\App\Helper\NumberHelper::numberFormat($payment->nominal_bayar)}}
                                            </label>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <label class="font-weight-normal">Sub Total: </label>
                                </td>
                                <td class="text-right">
                                    <label>Rp {{\App\Helper\NumberHelper::numberFormat($subTotal)}}</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <label class="font-weight-normal">Total Pengurangan: </label>
                                </td>
                                <td class="text-right">
                                    <label>
                                        @if($adjusmentAmount)
                                            Rp {{\App\Helper\NumberHelper::numberFormat($adjusmentAmount)}}
                                        @endif
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right">
                                    <label class="font-weight-normal">Total: </label>
                                </td>
                                <td class="text-right">
                                    <label>Rp {{\App\Helper\NumberHelper::numberFormat($total)}}</label>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                        data-dismiss="modal">{{config('constants.buttonTitle.close')}}</button>
                @if($isAdmin)
                    <a href="{{route('pembayaran.print.pdf', ['idMurid' => $idMurid, 'tglBayar' => $tglBayar])}}"
                       id="print" type="button" class="btn btn-primary" target="_blank">
                        <i class="fas fa-fw fa-print"></i>
                        {{config('constants.buttonTitle.print')}}
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
