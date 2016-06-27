<?php $__env->startSection('content'); ?>

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
                <?php /*vehicles table*/ ?>
                <table id="vehicle_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Vehicle Number</th>
                        <th>Vehicle Zone</th>
                        <th>Driver Name</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($allVehicles as $vehicle): ?>
                        <tr>
                            <td><?php echo e($vehicle->vehicle_number); ?></td>
                            <td><?php echo e($vehicle->zone_name); ?></td>
                            <td><?php echo e($vehicle->driver_name); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <form role="form"  method="post" action="<?php echo e(url('/addVehicle')); ?>">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="number">Vehicle Number</label>
                            <input type="text" class="form-control" name="number" id="number" placeholder="Enter Vehicle Number">
                        </div>
                        <div class="form-group">
                            <label>Driver</label>
                            <select class="form-control select2" name="driver" style="width: 100%;">
                                <?php foreach($driver_list as $driver): ?>
                                    <option value="<?php echo e($driver->driver_id); ?>"><?php echo e($driver->driver_name); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Vehicle Zone</label>
                            <select class="form-control select2" name="zone_id" style="width: 100%;">
                                <?php foreach($zones_list as $zone): ?>
                                    <option value="<?php echo e($zone->zone_id); ?>"><?php echo e($zone->zone_name); ?></option>
                                <?php endforeach; ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>