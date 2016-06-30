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
                        <th>Vehicle Status</th>
                        <th>Assigned Date</th>
                        <th>Assigned Customer Zone</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allVehicles as $vehicle)
                        <tr>
                            <td>{{$vehicle->vehicle_number}}</td>
                            <td>{{$vehicle->zone_name}}</td>
                            <td>{{$vehicle->driver_name}}</td>
                            @if($vehicle->isAssigned==1)
                                <td><span class="label label-danger" style="font-size: small">Assigned</span></td>
                            @else
                                <td><span class="label label-success" style="font-size: small">Available</span></td>
                            @endif

                            @if($vehicle->assigned_date=='0000-00-00 00:00:00')
                                <td  style="text-align: center;">-</td>
                            @else
                            <td>{{$vehicle->assigned_date}}</td>
                            @endif
                            <td>
                                <select class="form-control " id="customer_zone_{{$vehicle->vehicle_id}}" onchange="CustomerZoneSelected(this,'{{$vehicle->vehicle_id}}');">
                                    @if($vehicle->isAssigned==0)
                                        <option selected>Assign Customer Zone</option>
                                    @else
                                        <option value="{{$vehicle->customer_zone_name}}" selected>{{$vehicle->customer_zone_name}}</option>
                                    @endif
                                    @foreach($unassigned_customer_zones as $customer_zone)
                                        <option value="{{$customer_zone->zone_id}}">{{$customer_zone->zone_name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="row"><button class="btn btn-danger" style="font-size: x-large; margin: 1%;" onclick="ResetAllVehicles();">Reset All</button></div>
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

    //reset assigned vehicles to not assigned
    function ResetAllVehicles(){
        alertify.confirm('Are You Sure You Want to Reset All Assigned Vehicles ?', function(){
            $.ajax({
                url: "{{ url('/resetAllVehicles') }}",
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    alertify.success('Reset Successful')
                    location.reload();
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        });
    }

    function CustomerZoneSelected(customer_zone,vehicle_id){
        console.log();
        alertify.confirm('Are You Sure You Want to Assign the Vehicle to '+customer_zone.options[customer_zone.selectedIndex].text+'?', function(){
            $.ajax({
                url: "{{ url('/assignVehicleToCustomerZone') }}"+"/"+vehicle_id+"/"+customer_zone.value,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    //console.log(data);
                    alertify.success('Reset Successful')
                    location.reload();
                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        });
    }
</script>
@endsection