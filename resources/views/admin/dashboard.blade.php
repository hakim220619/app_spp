@extends('adminlte::page')

{{--@section('adminlte_css_pre')--}}
{{--    <link rel="stylesheet" href="{{ url('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css') }}">--}}
{{--@stop--}}

@section('card-body')
    <div class="card-body">
        {{-- Content Header --}}
        <div class="card-header">
            <div>
                <h3>Dashboard</h3>
            </div>
        </div>
        <div class="row">
        @include("vendor.template.dashboard-tab", [
            "background" => "bg-info",
            'data' => count($totalSiswa),
            'title' => 'Total Siswa'
        ])

        @include("vendor.template.dashboard-tab", [
        "background" => "bg-primary",
        'data' => count($totalSiswaPria),
        'title' => 'Total Siswa Laki-laki'
    ])

        @include("vendor.template.dashboard-tab", [
        "background" => "bg-warning",
        'data' => count($totalSiswaWanita),
        'title' => 'Total Siswa Perempuan'
    ])
        <!-- ./col -->
        </div>

        <div class="row">
            <section class="col-lg-6 connectedSortable ui-sortable">
                @include('vendor.template.chart-tab', [
    'title' => $titleTotalSpp,
    'id' => 'totalSpp'
    ])
                {{--            @include('vendor.template.direct-chat')--}}
                {{--            @include('vendor.template.to-do-list')--}}
            </section>

            <section class="col-lg-6 connectedSortable ui-sortable">
                @include('vendor.template.chart-tab', ['title' => 'Jumlah Siswa', 'id' => 'jumlahSiswa'])
                {{--            @include('vendor.template.direct-chat')--}}
                {{--            @include('vendor.template.to-do-list')--}}
            </section>
            {{--            <section class="col-lg-5 connectedSortable ui-sortable">--}}
            {{--                --}}{{--            @include('vendor.template.map')--}}
            {{--                @include('vendor.template.sales-graph')--}}
            {{--                --}}{{--            @include('vendor.template.calendar')--}}
            {{--            </section>--}}
        </div>
    </div>
@stop

@section('plugins.Chartjs', true)
@section('plugins.JqueryUI', true)
{{--@section('plugins.MomentJS', true)--}}
{{--@section('plugins.DateTimePicker', true)--}}
{{--@section('plugins.Knob', true)--}}
{{--@section('plugins.DateTimePicker', true)--}}
{{--@section('plugins.Sparkline', true)--}}

@section('js')
    <script>
        $(document).ready(function () {
            'use strict'
            $('.connectedSortable').sortable({
                placeholder: 'sort-highlight',
                connectWith: '.connectedSortable',
                handle: '.card-header, .nav-tabs',
                forcePlaceholderSize: true,
                zIndex: 999999
            })
            $('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move')

            var spp = document.getElementById('totalSpp').getContext('2d');

            var sppData = {
                labels: {!! json_encode($months) !!},
                datasets: {!! json_encode($dataSetsSpp) !!}
            };

            var sppOptions = {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }

            // This will get the first returned node in the jQuery collection.
            var sppChart = new Chart(spp, {
                    type: 'bar',
                    data: sppData,
                    options: sppOptions
                }
            );

            var totalSiswa = document.getElementById('jumlahSiswa').getContext('2d');

            var totalSiswaData = {
                labels: {!! json_encode($labelSiswa) !!},
                datasets: {!! json_encode($dataSetJumlahSiswa) !!}
            };

            var totalSiswaOptions = {
                responsive: true,
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }

            // This will get the first returned node in the jQuery collection.
            var totalSiswaChart = new Chart(totalSiswa, {
                    type: 'bar',
                    data: totalSiswaData,
                    options: totalSiswaOptions
                }
            )
        })
    </script>
@stop
