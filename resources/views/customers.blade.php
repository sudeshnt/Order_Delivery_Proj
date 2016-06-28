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
            Customers
        </h1>
    </section>

<!-- Custom Tabs -->
	   <div class="row">	
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">All Customers</a></li>
              <li><a href="#tab_2" data-toggle="tab">Add Customer</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
					{{--customer table--}}
				  <table id="customer_table"  class="table table-bordered table-hover allTables">
					  <thead>
					  <tr>
						  <th>Name</th>
						  <th>Business Name</th>
						  <th>Address</th>
						  <th>Customer Zone</th>
						  {{--<th>Zip</th>--}}
						  <th>Mobile</th>
					  </tr>
					  </thead>


					  <tbody>
					  @foreach ($allCustomers as $customer)
						  <tr>
							  <td>{{$customer->customer_name}}</td>
							  <td>{{$customer->business_name}}</td>
							  <td>{{$customer->customer_address}}</td>
							  <td>{{$customer->zone_name}}</td>
							  {{--<td>{{$customer->zip}}</td>--}}
							  <td>{{$customer->customer_mobile}}</td>
						  </tr>
					  @endforeach
					  </tbody>
				  </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                	<form role="form"  method="post" action="{{ url('/addCustomer') }}">
		            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
		              <div class="box-body">
		                <div class="form-group">
		                  <label for="name">Full Name</label>
		                  <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full Name" required>
		                </div>
		                <div class="form-group">
		                  <label for="bizz_name">Business Name</label>
		                  <input type="text" class="form-control" name="bizz_name" id="bizz_name" placeholder="Enter Business Name">
		                </div>
		                <div class="form-group">
		                  <label for="address">Adress</label>
		                  <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
		                </div>
		                {{--<div class="form-group">
		                  <label for="zip">Zip Code</label>
		                  <input type="text" pattern="[0-9]*" class="form-control" name="zip" id="zip" placeholder="Enter Zip Code" required>
		                </div>--}}
		                <div class="form-group">
			                <label>Customer Zone</label>
			                <select class="form-control select2" name="zone_id" style="width: 100%;">
			                    @foreach ($zones_list as $zone)
	                                <option value="{{$zone->zone_id}}">{{$zone->zone_name}}</option>
	                            @endforeach
			                </select>
			            </div>
		                <div class="form-group">
		                  <label for="mobile_no">Mobile Number</label>
		                  <input type="tel" class="form-control" name="mobile_no" id="mobile_no" placeholder="Enter Mobile Number" required>
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
		$('#customer_table').DataTable({
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