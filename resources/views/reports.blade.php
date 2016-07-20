@extends('master')

@section('content')
    @if(Request::path()==='reports/custom' || isset($filteredDate))
        <div class="row" style="margin:0px; padding:1%;">
            {{--date rage for filtering orders--}}
            <div class="form-group col-md-6">
                <label>Apply Date range:</label>
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    @if(isset($filteredDate))
                        <input type="text" class="form-control pull-right" id="reservation" value="{{$filteredDate}}">
                    @else
                        <input type="text" class="form-control pull-right" id="reservation">
                    @endif
                </div>
            </div>



            <div class="col-md-4">
                <div class="row" style="margin-top: 3px;">
                    <button class="btn btn-success" style="margin-top: 22px;" onclick="function filterReports() {
                                                 window.location='{{URL::to('reports')}}/'+$('#reservation').data('daterangepicker').startDate.format('YYYY-MM-DD')+','+$('#reservation').data('daterangepicker').endDate.format('YYYY-MM-DD');
                                            }
                                            filterReports();">Apply</button>
                    <button class="btn btn-danger" style="margin-top: 22px;" onclick="function clickedReset() {
                                                    window.location='{{URL::to('reports/custom')}}';
                                            }
                                            clickedReset();">Reset</button>
                </div>
            </div>
        </div>
    @endif
    <div style="padding: 1%;">
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-list"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Value of Total Sales</span>
                    <span class="info-box-number"><small>₦ </small> {{$total_sales}} </span>
                    <span class="info-box-number"><small style="color: #00a65a;">Total Paid  ₦ {{$total_settled}}</small></span>
                    <span class="info-box-number"><small style="color: #dd4b39;">Total Due ₦ {{$total_due_payments}}</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="fa fa-usd"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Payments Recieved</span>
                    <span class="info-box-number"> ₦ {{$total_income}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-4 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">All Units Sold</span>
                    <span class="info-box-number">{{$total_units_sold}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <!-- Content Header (Page header) -->
   {{--<div>
        <section class="content-header">
            <h1> All {{$option}} Orders </h1>
        </section>
   </div>--}}
    <div class="row" style="margin: 1%;">
        <section class="content-header" style="padding: 0px 15px 15px 15px;">
            <h1>
                All {{$option}} Orders
            </h1>
        </section>
        <div class="panel">
            {{--customer table--}}
            <table id="orders_table"  class="table table-bordered table-hover allTables">
                <thead>
                <tr>
                    <th>Date</th>
                    <th style="width: 36px;">Order Code</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th style="width: 56px;">Payment Status</th>
                    <th style="width: 52px;">Delivery Status</th>
                    <th>Delivered By</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($allOrders as $order)
                    <tr{{-- onclick="getOrderDetails('{{$order->order_code}}')"--}}>
                        <td>{{$order->order_date}}</td>
                        <td>{{$order->order_code}}</td>
                        <td>{{$order->customer_name}}</td>
                        <td>₦ {{$order->full_amount}}</td>
                        <td>₦ {{$order->paid_amount}}</td>
                        <td>₦ {{$order->full_amount-$order->paid_amount}}</td>
                        @if($order->isPaid)
                            <td><span class="label label-success" style="font-size: small">Paid</span></td>
                        @else
                            <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                        @endif
                        @if($order->isDelivered)
                            <td><span class="label label-success" style="font-size: small">Delivered</span></td>
                        @else
                            <td><span class="label label-danger" style="font-size: small">Pending</span></td>
                        @endif
                        @if($order->deliveryType=='byVehicle')
                            <td>{{$order->vehicle_number}} : {{$order->driver_name}}</td>
                        @else
                            <td>delivered on the spot</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row" style="margin: 1%;">
        <div class="col-md-6" style="padding: 0px">
            <section class="content-header" style="padding: 0px 15px 15px 15px;">
                <h1>
                    All {{$option}} Sold Products
                </h1>
            </section>
            <div class="panel">
                <table id="products_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Qty</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($qty_of_products as $key => $value)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6" style="padding: 0px 0px 0px 1%">
            <section class="content-header" style="padding: 0px 15px 15px 15px;">
                <h1>
                    All {{$option}} Payment Reports
                </h1>
            </section>
            <div class="panel">
                <table id="payments_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Payment Reference</th>
                        <th>Payment Date</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($payment_reports as $payment)
                        <tr>
                            <td>{{$payment->payment_id}}</td>
                            <td>{{$payment->payment_date}}</td>
                            <td>₦ {{$payment->amount}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row" style="margin: 1%;">
        <div class="col-md-12" style="padding: 0px">
            <section class="content-header" style="padding: 0px 15px 15px 15px;">
                <h1>
                    All {{$option}} Deliveries
                </h1>
            </section>
            <div class="panel">
                <table id="deliveries_table"  class="table table-bordered table-hover allTables">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th style="width: 36px;">Order Code</th>
                        <th>Customer</th>
                        <th>Units Carried</th>
                        <th>Delivered By</th>
                        <th>Received By</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($allDeliveries as $delivery)
                        <tr>
                            <td>{{$delivery->order_date}}</td>
                            <td>{{$delivery->order_code}}</td>
                            <td>{{$delivery->customer_name}}</td>
                            <td>{{$delivery->total_qty}} units of {{$delivery->num_product}} products</td>
                            <td>{{$delivery->vehicle_number}} : {{$delivery->driver_name}}</td>
                            <td>{{$delivery->whoReceived}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        $(function () {
            $('#orders_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        $(function () {
            $('#payments_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        $(function () {
            $('#products_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        $(function () {
            $('#deliveries_table').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false
            });
        });

        $('#reservation').daterangepicker();
    </script>
@endsection