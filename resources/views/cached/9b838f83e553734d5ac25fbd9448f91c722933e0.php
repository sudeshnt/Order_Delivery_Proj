<?php $__env->startSection('content'); ?>

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
				 <?php /*accordian starts*/ ?>
				  <?php foreach($customers_in_each_zone as $key => $value): ?>
					  <div class="panel-group" id="accordion">

						  <div class="panel panel-default">
							  <div class="panel-heading">
								  <h4 class="panel-title">
									  <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo e(++$index); ?>"><?php echo e($key); ?></a>
								  </h4>
							  </div>
							  <div id="collapse<?php echo e($index); ?>" class="panel-collapse collapse">

								  <div class="panel-body">

									  <table id="example<?php echo e($index); ?>"  class="table table-bordered table-hover allTables">
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
										  <?php foreach($value as $customer): ?>
											  <tr>
												  <td><?php echo e($customer->customer_name); ?></td>
												  <td><?php echo e($customer->business_name); ?></td>
												  <td><?php echo e($customer->customer_address); ?></td>
												  <td><?php echo e($customer->zip); ?></td>
												  <td><?php echo e($customer->customer_mobile); ?></td>
											  </tr>
										  <?php endforeach; ?>
										  </tbody>
									  </table>

								  </div>
							  </div>
						  </div>
					  </div>

				  <?php endforeach; ?>

              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                	<form role="form"  method="post" action="<?php echo e(url('/addCustomerZone')); ?>">
		            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">  
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
			"ordering": false,
			"info": true,
			"autoWidth": false
		});
	});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>