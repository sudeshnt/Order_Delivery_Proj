@extends('master')

@section('content')

    <style type="text/css">
        .row {
            margin: 0%;
        }
    </style>
        <!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Vehicles
    </h1>
</section>

<!-- Custom Tabs -->
<div class="row">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">All Vehicles</a></li>
            <li><a href="#tab_2" data-toggle="tab">Add Vehicle</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                {{--vehicles table--}}
                <table id="vehicle_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Vehicle Number</th>
                        <th>Vehicle Zone</th>
                        <th>Driver Name</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allVehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->vehicle_number}}</td>
                            <td>{{$vehicle->zone_name}}</td>
                            <td>{{$vehicle->driver_name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row"><button class="btn btn-danger" style="font-size: x-large; margin: 1%;">Reset All</button></div>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <form role="form"  method="post" action="{{ url('/addVehicle') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="number">Vehicle Number</label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="Enter Vehicle Number">
                        </div>
                        <div class="form-group">
                            <label>Driver</label>
                            <select class="form-control select2" name="driver" style="width: 100%;">
                                @foreach ($driver_list as $driver)
                                    <option value="{{$driver->driver_id}}">{{$driver->driver_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Zone</label>
                            <select class="form-control select2" name="zone_id" style="width: 100%;">
                                @foreach ($zones_list as $zone)
                                    <option value="{{$zone->zone_id}}">{{$zone->zone_name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.tab-content -->
    </div>
</div>

<script>
    $(function () {
        $('#vehicle_table').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": false,
            "info": true,
            "autoWidth": false
        });
    });
</script>
@endsection