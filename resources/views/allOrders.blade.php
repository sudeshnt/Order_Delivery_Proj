@extends('master')

@section('content')
    <style>
        .table-hover>tbody>tr:hover{
            background-color:#f5f5f5;
        }

        .invoice {

             border: 1px solid #f4f4f4;
             padding: 0px;
             margin: 0px 0px;
        }
    </style>


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            All Orders
        </h1>
    </section>

    <div class="panel">
        {{--customer table--}}
        <table id="orders_table"  class="table table-bordered table-hover allTables">
            <thead>
            <tr>
                <th>Date</th>
                <th>Order Code</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Paid</th>
                <th>Balance</th>
                <th>Payment Status</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($allOrders as $order)
                <a><tr onclick="getOrderDetails('{{$order->order_code}}')">
                    <td>{{$order->created_at}}</td>
                    <td>{{$order->order_code}}</td>
                    <td>{{$order->customer_name}}</td>
                    <td>{{$order->full_amount}}</td>
                    <td>{{$order->paid_amount}}</td>
                    <td>{{$order->full_amount-$order->paid_amount}}</td>
                    @if($order->isPaid)
                        <td>Paid</td>
                    @else
                        <td>Pending</td>
                    @endif
                    <td></td>
                </tr></a>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="well well-lg">asdasdsa</div>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <section class="invoice" id="printableArea">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="page-header">
                                        <i class="fa fa-globe"></i> AdminLTE, Inc.
                                        <small class="pull-right">Date: 2/10/2014</small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>Admin, Inc.</strong><br>
                                        795 Folsom Ave, Suite 600<br>
                                        San Francisco, CA 94107<br>
                                        Phone: (804) 123-5432<br>
                                        Email: info@almasaeedstudio.com
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">

                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #007612</b><br>
                                    <br>
                                    <b>Order ID:</b> 4F3S8J<br>
                                    <b>Payment Due:</b> 2/22/2014<br>
                                    <b>Account:</b> 968-34567
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Qty</th>
                                            <th>Product</th>
                                            <th>Serial #</th>
                                            <th>Description</th>
                                            <th>Subtotal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Call of Duty</td>
                                            <td>455-981-221</td>
                                            <td>El snort testosterone trophy driving gloves handsome</td>
                                            <td>$64.50</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Need for Speed IV</td>
                                            <td>247-925-726</td>
                                            <td>Wes Anderson umami biodiesel</td>
                                            <td>$50.00</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Monsters DVD</td>
                                            <td>735-845-642</td>
                                            <td>Terry Richardson helvetica tousled street art master</td>
                                            <td>$10.70</td>
                                        </tr>
                                        <tr>
                                            <td>1</td>
                                            <td>Grown Ups Blue Ray</td>
                                            <td>422-568-642</td>
                                            <td>Tousled lomo letterpress</td>
                                            <td>$25.99</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-xs-6">

                                </div>
                                <!-- /.col -->
                                <div class="col-xs-6">
                                    <p class="lead">Amount Due 2/22/2014</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>$250.30</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </section>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="button" class="btn btn-primary" onclick="generate_products_table();" style="margin-bottom: -3%">Save List</button>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


    <script>
        $(function () {
            $('#orders_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": false,
                "info": true,
                "autoWidth": false
            });
        });

        function getOrderDetails(order_code){
            $('#myModal').modal('show');
            $.ajax({
                url: "{{ url('/getOrderDetails') }}"+"/"+order_code,
                type: "get",
                dataType: 'json',
                async:true,
                success: function(data){
                    console.log(data);

                },
                error: function(data)
                {
                    console.log("error");
                }
            });
        }
    </script>
@endsection