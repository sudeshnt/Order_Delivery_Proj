@extends('master')

@section('content')
	<section class="content-header">
        <h1>
            Vehicle Zones
        </h1>
    </section>
<!-- Custom Tabs -->
	   <div class="row">	
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">All Vehicle Zones</a></li>
              <li><a href="#tab_2" data-toggle="tab">Add Vehicle Zone</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
				  {{--accordian starts--}}
				  @foreach ($vehicles_in_each_zone as $key => $value)
					  <div class="panel-group" id="accordion">

						  <div class="panel panel-default">
							  <div class="panel-heading">
								  <h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{++$index}}">{{$key}}</a>
								  </h4>
							  </div>
							  <div id="collapse{{$index}}" class="panel-collapse collapse">

								  <div class="panel-body">

									  <table id="example{{$index}}"  class="table table-bordered table-hover allTables">
										  <thead>
										  <tr>
											  <th>Vehicle Number</th>
											  <th>Driver Name</th>
											  <th>Current Status</th>
										  </tr>
										  </thead>


										  <tbody>
										  @foreach ($value as $vehicle)
											  <tr>
												  <td>{{$vehicle->vehicle_number}}</td>
												  <td>{{$vehicle->driver_name}}</td>
												  @if($vehicle->isAssigned==0)
												  	  <td><span class="label label-success" style="font-size: small">Available</span></td>
												  @else
													  <td><span class="label label-danger" style="font-size: small">Assigned</span></td>
												  @endif
											  </tr>
										  @endforeach
										  </tbody>
									  </table>

								  </div>
							  </div>
						  </div>
					  </div>

				  @endforeach

			  </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                	<form role="form"  method="post" action="{{ url('/addVehicleZone') }}">
		            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
		              <div class="box-body">
		                <div class="form-group">
		                  <label for="vehicle_zone">Vehicle Zone Name</label>
		                  <input type="text" class="form-control" name="vehicle_zone" id="vehicle_zone" placeholder="Enter Vehicle Zone Name" required>
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

@endsection