<div class="card">
    <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">
            {{$title}}
        </h3>
        {{--        <div class="card-tools">--}}
        {{--            <ul class="nav nav-pills ml-auto">--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Area</a>--}}
        {{--                </li>--}}
        {{--                <li class="nav-item">--}}
        {{--                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>--}}
        {{--                </li>--}}
        {{--            </ul>--}}
        {{--        </div>--}}
    </div><!-- /.card-header -->
    <div class="card-body">
        <div class="tab-content p-0">
            <!-- Morris chart - Sales -->
            <div class="chart tab-pane active" id="{{$id}}Div"
                 style="position: relative; height: 300px;">
                <div class="chartjs-size-monitor">
                    <div class="chartjs-size-monitor-expand">
                        <div class=""></div>
                    </div>
                    <div class="chartjs-size-monitor-shrink">
                        <div class=""></div>
                    </div>
                </div>
                <canvas id="{{$id}}" height="600"
                        style="height: 300px; display: block; width: 630px;" width="1260"
                        class="chartjs-render-monitor"></canvas>
            </div>
            {{--            <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">--}}
            {{--                <canvas id="sales-chart-canvas" height="0" style="height: 0px; display: block; width: 0px;"--}}
            {{--                        width="0" class="chartjs-render-monitor"></canvas>--}}
            {{--            </div>--}}
        </div>
    </div><!-- /.card-body -->
</div>
