@extends('master')

@section('content')

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

@endsection