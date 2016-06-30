@extends('master')

@section('content')

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
                <li><a href="#tab_3" data-toggle="tab">Add Stock</a></li>
                <li><a href="#tab_2" data-toggle="tab">Add Product</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    {{--company table--}}
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
                        @foreach ($allProducts as $product)
                            <tr>
                                <td>{{$product->product_name}}</td>
                                <td>{{$product->product_code}}</td>
                                <td>{{$product->company_name}}</td>
                                <td>{{$product->available_amount}}</td>
                                <td>{{$product->unit_price}}</td>
                                <td>{{$product->product_size}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                        <div class="box-body">

                            <div id="add_new_product">
                                <form role="form" method="post" action="{{ url('/addProduct') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="company_id">Company Name</label>
                                    <select class="form-control select2" name="company_id" id="company_id" style="width: 100%;">
                                        <option>Select Company</option>
                                        @foreach ($allCompanies as $company)
                                            <option value="{{$company->company_id}}">{{$company->company_name}}</option>
                                        @endforeach
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
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.box-body -->
                </div>
                <div class="tab-pane active" id="tab_3">
                    <div class="box-body">
                        <div id="add_stock_for_existing_product">
                            <form role="form" method="post" action="{{ url('/addStockExistingProduct') }}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="product_id">Product</label>
                                    <select class="form-control select2" name="product_id" id="product_id" style="width: 100%;">
                                             <option>Select Product</option>
                                        @foreach ($allProducts as $product)
                                            <option value="{{$product->product_id}}">{{$product->product_code}} : {{$product->product_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="added_amount">Added Amount</label>
                                    <input type="number" class="form-control" name="added_amount" id="added_amount" placeholder="Enter Added Amount" required>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
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

@endsection