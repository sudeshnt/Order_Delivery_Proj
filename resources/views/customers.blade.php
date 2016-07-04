@extends('master')

@section('content')

	<style type="text/css">
		.row {
			margin: 0%;
		}

		.box.box-solid.box-default>.box-header {
			color: #444;
			background: #fff;
			background-color: #fff;
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
						  <th>Email</th>
						  <th>Address</th>
						  <th>Customer Zone</th>
						  <th>Mobile</th>
						  <th></th>
					  </tr>
					  </thead>


					  <tbody>
					  @foreach ($allCustomers as $customer)
						  <tr>
							  @if($customer->isOwed==true)
								  <td>{{$customer->customer_name}}<i class="fa fa-usd  fa-lg" aria-hidden="true" style="float: right; color: rgba(253, 49, 49, 0.81)"></i> </td>
							  @else
								  <td>{{$customer->customer_name}}</td>
							  @endif
							  <td>{{$customer->business_name}}</td>
							  <td>{{$customer->email}}</td>
							  <td>{{$customer->customer_address}}</td>
							  <td>{{$customer->zone_name}}</td>
							  <td>{{$customer->customer_mobile}}</td>
							  <td style="text-align: center;" onclick="showCustomerOrders('{{$customer->customer_id}}');"><i class="fa fa-eye fa-2x" aria-hidden="true"></i></td>
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
						  <div class="form-group">
							  <label for="email">Email Address</label>
							  <input type="email" class="form-control" name="email" id="email" placeholder="Enter Email Address" required>
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
	{{--orders_modal--}}
	<div class="modal fade" tabindex="-1" role="dialog" id="orders_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Orders</h4>
				</div>
				<div class="modal-body">
					<div class="row" style="margin: 10px;">
						<div class="col-md-8"></div>
						<i class="fa fa-check-circle  fa-lg" aria-hidden="true" style="margin-right: 10px; color: rgba(48, 193, 74, 0.84)"></i> : Paid and Deliverd
					</div>
					<div class="row" style="margin: 10px;">
						<div class="col-md-8"></div>
						<i class="fa fa-truck  fa-lg" aria-hidden="true" style="margin-right: 10px; color: rgba(253, 49, 49, 0.81)"></i> : Not Deliverd
					</div>
					<div class="row" style="margin: 10px; margin-bottom: 25px">
						<div class="col-md-8"></div>
						<i class="fa fa-usd  fa-lg" aria-hidden="true" style="margin-right: 16px; color: rgba(253, 49, 49, 0.81)"></i>   : Payment not Completed
					</div>
					<div class="row" style="padding: 10px;">
						<div id="customer_orders_holder" style="overflow-y: scroll; max-height:300px;">

						</div>
					</div>
					<div id="total_owe" style="text-align: right; color: #fd5757; font-size: x-large;">

					</div>
				</div>
			</div>
		</div>
	</div>

<script>
	$(function () {
		$('#customer_table').DataTable({
			"paging": true,
			"lengthChange": false,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false
		});
	});

	function showCustomerOrders(customer_id){
		$.ajax({
			url: "{{ url('/getCustomerOrders') }}"+"/"+customer_id,
			type: "get",
			dataType: 'json',
			async:true,
			success: function(data){
				console.log(data);
				var HTML = '';
				var total_owe = 0;
				for(order in data){
					console.log(order);
					HTML+='<div class="row" style="margin-right:6%">'+
							'<div class="box box-default collapsed-box box-solid">'+
								'<div class="box-header with-border">'+
									'<h3 class="box-title">'+data[order].order_date+' : '+data[order].order_code+'</h3>'+
									'<div class="box-tools pull-right">';
					if(data[order].isDelivered==1 && data[order].isPaid==1)
						HTML+='<i class="fa fa-check-circle fa-2x" aria-hidden="true" style="margin-right: 10px; color: rgba(48, 193, 74, 0.84)"></i>';
					if(data[order].isDelivered==0)
					HTML+='<i class="fa fa-truck fa-2x" aria-hidden="true" style="margin-right: 10px; color: rgba(253, 49, 49, 0.81)"></i>';
					if(data[order].isPaid==0)
					HTML+='<i class="fa fa-usd fa-2x" aria-hidden="true" style="margin-right: 10px; margin-left: 10px; color: rgba(253, 49, 49, 0.81)"></i>';

					HTML+='<button type="button" class="btn btn-box-tool" data-widget="collapse" style="vertical-align: super;"><i class="fa fa-plus fa-lg"></i>'+
							'</button>'+ '</div>'+
						'</div>'+
						'<div class="box-body">';
					HTML+='Order Date : '+data[order].order_date+'<br>';
					if(data[order].isDelivered==1)
					{
						HTML+='Delivered Date : '+data[order].delivered_at+'<br>';
						HTML+='Delivered By : '+data[order].vehicle_number+' , '+data[order].driver_name+'<br>'+'Received By : '+data[order].whoReceived+'<br>';
					}
					else {
						HTML+='Assigned Vehicle : '+data[order].vehicle_number+' , '+data[order].driver_name+'<br>';
					}
					HTML+='Order Value : ₦ '+data[order].full_amount+'<br>'+'Paid Amount : ₦ '+data[order].paid_amount+'<br>';
					if(data[order].isPaid==0)
						HTML+='<p style="color: #FD3131;">Due Payment : ₦ '+(data[order].full_amount-data[order].paid_amount)+'</p>';


					HTML+='</div>'+
						'</div>'+
					'</div>';

					total_owe += data[order].full_amount - data[order].paid_amount;
				}
				document.getElementById("customer_orders_holder").innerHTML =HTML;
				document.getElementById("total_owe").innerHTML = "Customers Due Payment : " + total_owe;
				$('#orders_modal').modal('show');
			},
			error: function(data)
			{
				console.log("error");
			}
		});
	}
</script>
@endsection          