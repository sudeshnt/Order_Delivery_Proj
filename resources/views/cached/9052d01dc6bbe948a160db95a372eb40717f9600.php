<?php $__env->startSection('content'); ?>


    <section class="content-header">
        <h1>
            Companies
        </h1>
    </section>
    <!-- Custom Tabs -->
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Companies</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Company</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php /*company table*/ ?>
                    <table id="company_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Company Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($allCompanies as $company): ?>
                            <tr>
                                <td><?php echo e($company->company_name); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form role="form"  method="post" action="<?php echo e(url('/addCompany')); ?>">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="comp_name">Company Name</label>
                                <input type="text" class="form-control" name="company_name" id="comp_name" placeholder="Enter Company Name" required>
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
    <?php /*<script>
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
    </script>*/ ?>







<?php $__env->stopSection(); ?>
<?php echo $__env->make('master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>