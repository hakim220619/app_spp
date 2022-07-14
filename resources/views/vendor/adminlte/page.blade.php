@extends('adminlte::master')

@inject('layoutHelper', 'JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper')

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    <div class="wrapper">

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif

        {{-- Content Wrapper --}}
        <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session()->get('message') ? session()->get('message') : "" }}
                </div>
            @endif

            <div class="card">
                {{--                <div class="card-body">--}}
                {{--                    --}}{{-- Content Header --}}
                {{--                    <div class="card-header">--}}
                {{--                        <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">--}}
                {{--                            @yield('content_header')--}}
                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                    --}}{{-- Main Content --}}
                {{--                    <div class="card-body table-responsive content">--}}
                {{--                        <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">--}}
                {{--                            @yield('content')--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}

                @yield('card-body')

            </div>

        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

        {{--        <div class="modal fade" id="@yield('modal_id')" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"--}}
        {{--             aria-hidden="true">--}}
        {{--            <div class="modal-dialog" role="document">--}}
        {{--                <div class="modal-content">--}}
        {{--                    <div class="modal-header">--}}
        {{--                        <h5 class="modal-title" id="exampleModalLabel"></h5>--}}
        {{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--                            <span aria-hidden="true">&times;</span>--}}
        {{--                        </button>--}}
        {{--                    </div>--}}
        {{--                    <div class="modal-body">--}}
        {{--                        @yield('modal_body')--}}
        {{--                    </div>--}}
        {{--                    <div class="modal-footer">--}}
        {{--                        @yield('modal_button')--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

    </div>
@stop

@section('adminlte_js')
    <script>
        window.livewire.on('{{config('constants.modal.open')}}', (param) => {
            $(`#${param || 'modal'}`).modal({backdrop: 'static', keyboard: false});
        })
        window.livewire.on('{{config('constants.modal.close')}}', (param) => {
            $(`#${param || 'modal'}`).modal('hide');
        })

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }

        $('[data-toggles="tooltip"]').tooltip();
    </script>
    @stack('js')
    @yield('js')
@stop
