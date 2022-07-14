<html>
<head>
    <title>Laporan</title>
    <style type="text/css">
        label {
            display: inline-block;
            margin: 0;
        }

        table {
            border-spacing: 0;
            border: 1px solid black;
            border-right: none;
            border-bottom: none;
        }

        td, th {
            border: 1px solid black;
            border-top: none;
            border-left: none;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <label style="font-weight: bold">TK/SD/SMP Islam Alhasanah</label>
        </div>
        <div class="col-md-12">
            <label style="font-weight: bold">Alamat: Jl. Hos Cokroaminoto no 2 sudimara barat ciledug tangerang</label>
        </div>
    </div>
    <br/>
    <div class="row">
        <label>Nama:</label>
        <label style="font-weight: bold; margin-right: 18px">{{$nis}} - {{$studentName}}</label>
        <label>Metode:</label>
        <label style="font-weight: bold; margin-right: 18px">{{$paymentMethod}}</label>
        <span>Unit:</span>
        <label style="font-weight: bold; margin-right: 18px">{{$unitName}}</label>
        <span>Kelas:</span>
        <label style="font-weight: bold">{{$className}}</label>
    </div>
    <table style="width: 100%">
        <tr>
            <th style="width: 20%">Kategori</th>
            <th style="width: 60%">Bulan / Tahun</th>
            <th style="width: 20%">Total</th>
        </tr>
        @if(!empty($payments))
            @foreach($payments as $payment)
                <tr>
                    <td>
                        <label>{{$payment->kategory_payment}}
                            - {{$payment->tipe_pembayaran}}</label>
                    </td>
                    <td>
                        <label>{{$payment->deskripsi}}</label>
                    </td>
                    <td>
                        <label style="display: block;text-align: right;">
                            Rp {{\App\Helper\NumberHelper::numberFormat($payment->nominal_bayar)}}
                        </label>
                    </td>
                </tr>
            @endforeach
        @endif
        <tr>
            <td colspan="2">
                <label style="display: block;text-align: right;font-weight: bold">Sub Total: </label>
            </td>
            <td>
                <label
                    style="display: block;text-align: right">Rp {{\App\Helper\NumberHelper::numberFormat($subTotal)}}</label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label style="display: block;text-align: right;font-weight: bold">Total Pengurangan: </label>
            </td>
            <td>
                <label style="display: block;text-align: right">
                    @if($adjusmentAmount)
                        Rp {{\App\Helper\NumberHelper::numberFormat($adjusmentAmount)}}
                    @else
                        Rp 0
                    @endif
                </label>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <label style="display: block;text-align: right;font-weight: bold">Total: </label>
            </td>
            <td>
                <label
                    style="display: block;text-align: right;">Rp {{\App\Helper\NumberHelper::numberFormat($total)}}</label>
            </td>
        </tr>
    </table>
    <div class="row">
        <div>
            <label>Terbilang: {{$terbilang}} Rupiah</label>
        </div>
        <div style="margin-top: 4px;">
            <label>"Bukti pembayaran ini harap simpan dan jangan hilang"</label>
            <div style="position: absolute; right: 0">
                <label>Pukul: {{date("H:i:s",strtotime($tglBayar))}}</label>
                <label>Tanggal: {{date("d-F-Y",strtotime($tglBayar))}}</label>
            </div>
        </div>
        <div>
            <label>Diterima</label>
        </div>
    </div>
</div>
</body>
</html>
