@extends('master')

@section('content')

	<style type="text/css">
		.row {
			margin: 0%;
		}
	</style>

	<section class="content-header">
        <h1>
            Customer Zones
        </h1>
    </section>

<!-- Custom Tabs -->
	   <div class="row">	
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">All Customer Zones</a></li>
              <li><a href="#tab_2" data-toggle="tab">Add Customer Zone</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
				 {{--accordian starts--}}
				  @foreach ($customers_in_each_zone as $key => $value)
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
											  <th>Name</th>
											  <th>Business Name</th>
											  <th>Address</th>
											  <th>Zip</th>
											  <th>Mobile</th>
										  </tr>
										  </thead>


										  <tbody>
										  @foreach ($value as $customer)
											  <tr>
												  <td>{{$customer->customer_name}}</td>
												  <td>{{$customer->business_name}}</td>
												  <td>{{$customer->customer_address}}</td>
												  <td>{{$customer->zip}}</td>
												  <td>{{$customer->customer_mobile}}</td>
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
                	<form role="form"  method="post" action="{{ url('/addCustomerZone') }}">
		            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
		              <div class="box-body">
		                <div class="form-group">
		                  <label for="customer_zone">Customer Zone Name</label>
		                  <input type="text" class="form-control" name="customer_zone" id="customer_zone" placeholder="Enter Customer Zone Name" required>
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


	<!-- jQuery 2.2.0 -->

	<!-- data tables -->

<script>
	$(function () {
		$('.allTables').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": false,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});
</script>

@endsection