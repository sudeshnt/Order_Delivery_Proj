<?php $__env->startSection('content'); ?>
    <section class="content-header">
        <h1>
            Drivers
        </h1>
    </section>
    <!-- Custom Tabs -->
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Drivers</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Drivers</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php /*drivers table*/ ?>
                    <table id="drivers_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Driver Number</th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($allDrivers as $driver): ?>
                            <tr>
                                <td><?php echo e($driver->driver_name); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form role="form"  method="post" action="<?php echo e(url('/addDriver')); ?>">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name">Driver's Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Driver's Name" required>
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
            $('#drivers_table_table').DataTable({
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