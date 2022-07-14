@extends('adminlte::page')

@section('card-body')
    <livewire:pembayaran-livewire/>
@stop

{{--@section('plugins.Datatables', true)--}}
{{--@section('plugins.MomentJS', true)--}}
{{--@section('plugins.DateRangePicker', true)--}}

{{--@section('js')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            $('#table_id').DataTable();--}}

{{--            $('input[name="daterange"]').daterangepicker({--}}
{{--                startDate: moment().clone().startOf('month').format('DD/MM/YYYY'),--}}
{{--                endDate: moment().clone().endOf('month').format('DD/MM/YYYY'),--}}
{{--                locale: {--}}
{{--                    format: "DD/MM/YYYY"--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}

{{--        $('#pembayaranModal').on('show.bs.modal', function (event) {--}}
{{--            var button = $(event.relatedTarget);--}}
{{--            var type = button.data("type");--}}
{{--            // var pembayaran = button.data('pembayaran');--}}
{{--            var modal = $(this);--}}
{{--            modal.find("#type").val(type);--}}
{{--            if (type === 'add') {--}}
{{--                $(".add").show();--}}
{{--                $(".search").hide();--}}
{{--                modal.find(".modal-title").text("Cari Data");--}}
{{--            } else if (type === 'search') {--}}
{{--                $(".add").hide();--}}
{{--                $(".search").show();--}}
{{--                modal.find(".modal-title").text("Tambah Data");--}}
{{--            }--}}
{{--        });--}}

{{--        $('#save').on('click', function () {--}}
{{--            console.log("ASD")--}}
{{--            $('#pembayaranModal').modal('hide');--}}
{{--        })--}}
{{--    </script>--}}
{{--@endsection--}}
