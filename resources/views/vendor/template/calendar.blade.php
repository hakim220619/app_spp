<div class="card bg-gradient-success" style="position: relative; left: 0px; top: 0px;">
    <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">

        <h3 class="card-title">
            <i class="far fa-calendar-alt"></i>
            Calendar
        </h3>
        <!-- tools card -->
        <div class="card-tools">
            <!-- button with a dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                    <i class="fas fa-bars"></i></button>
                <div class="dropdown-menu float-right" role="menu" x-placement="bottom-start"
                     style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 31px, 0px);">
                    <a href="#" class="dropdown-item">Add new event</a>
                    <a href="#" class="dropdown-item">Clear events</a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">View calendar</a>
                </div>
            </div>
            <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <!-- /. tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body pt-0">
        <!--The calendar -->
        <div id="calendar" style="width: 100%">
        </div>
    </div>
    <!-- /.card-body -->
</div>
