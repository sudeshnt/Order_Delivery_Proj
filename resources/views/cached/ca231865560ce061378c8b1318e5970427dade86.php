<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1>
            Products
        </h1>
    </section>
    <!-- Custom Tabs -->
    <style type="text/css">
        .row {
            margin: 0%;
        }
    </style>
    <div class="row">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">All Products</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Product</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <?php /*company table*/ ?>
                    <table id="products_table"  class="table table-bordered table-hover allTables">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Code</th>
                            <th>Company Name</th>
                            <th>Available Amount</th>
                            <th>Unit Price</th>
                            <th>Product Size</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($allProducts as $product): ?>
                            <tr>
                                <td><?php echo e($product->product_name); ?></td>
                                <td><?php echo e($product->product_code); ?></td>
                                <td><?php echo e($product->company_name); ?></td>
                                <td><?php echo e($product->available_amount); ?></td>
                                <td><?php echo e($product->unit_price); ?></td>
                                <td><?php echo e($product->product_size); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                    <form role="form" method="post" action="<?php echo e(url('/addProduct')); ?>">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="company_id">Company Name</label>
                                <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;">
                                    <?php foreach($allCompanies as $company): ?>
                                        <option value="<?php echo e($company->company_id); ?>"><?php echo e($company->company_name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter Product Name" required>
                            </div>
                            <div class="form-group">
                                <label for="product_code">Product Code</label>
                                <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter Product Code" required>
                            </div>
                            <div class="form-group">
                                <label for="product_amount">Added Amount</label>
                                <input type="number" class="form-control" name="product_amount" id="product_amount" placeholder="Enter Amount" required>
                            </div>
                            <div class="form-group">
                                <label for="product_unitprice">Unit Price</label>
                                <input type="text" class="form-control" name="product_unitprice" id="product_unitprice" placeholder="Enter Unit Price" required>
                            </div>
                            <div class="form-group">
                                <label for="product_size">Product Size</label>
                                <input type="text" class="form-control" name="product_size" id="product_size" placeholder="Enter Product Size" required>
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
            $('#products_table').DataTable({
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