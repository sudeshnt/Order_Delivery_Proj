@extends('master')

@section('content')

    <style>
        .row1 {
            margin:-2%;
        }
    </style>

<div class="panel">
    <form role="form" method="post" action="{{ url('/addOrder') }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
            <div class="row" style="margin-bottom: auto;">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_date">Date</label>
                        <input type="text" name="order_date" id="order_date" class="form-control pull-right" id="datepicker">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="order_id">Order ID</label>
                        <input type="text" class="form-control" name="order_id" id="order_id" required>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
            <div class="row col-md-9">
                <div class="form-group">
                    <label for="customer_name">Customer</label>
                    <select class="form-control select2" name="zone_id" style="width: 100%;">
                        @foreach ($allCustomers as $customer)
                            <option value="{{$customer->customer_id}}">{{$customer->customer_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_code">Add Products</label>
                    <button class="btn btn-primary" id="add">add</button>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

    </form>
</div>

{{--Modal--}}
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Modal title</h4>
                </div>
                <div class="modal-body">
                    {{--<form onSubmit="captureForm()">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">--}}
                        <div class="box-body">
                            <div class="form-group">
                                <label for="product_id">Product Name</label>
                                <select class="form-control select2 product_details" name="product_id" id="product_id" style="width: 100%;">
                                    @foreach ($allProducts as $product)
                                        <option value="{{$product->product_id}}">{{$product->product_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="product_details" class="callout callout-Info" hidden></div>
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="number" min="1" class="form-control" name="qty" id="qty" placeholder="Enter Quantity" required>
                            </div>
                        </div>
                        <div id="products_on_order">

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button class="btn btn-primary" onclick="addProduct(document.getElementById('product_id').value,document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex].text,document.getElementById('qty').value)">Submit</button>
                            <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                   {{-- </form>--}}
                </div>
                {{--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>--}}
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<script>


    //Date picker
    $('#datepicker').datepicker({
        autoclose: true
    });

    $( "#add" ).click(function() {
        $('#myModal').modal('show');
    });

    var products_on_order = [];
    $( ".product_details" ).change(function() {

        var flag_isAlreadyAdded = false;
        for(product in products_on_order){
            if(products_on_order[product].product_id==this.options[this.selectedIndex].value){
                document.getElementById("qty").value =products_on_order[product].qty;
                flag_isAlreadyAdded=true;
            }
        }
        if(!flag_isAlreadyAdded){
            document.getElementById("qty").value ='';
        }
        $.ajax({
            url: "{{ url('/getProduct') }}"+"/"+this.options[this.selectedIndex].value,
            type: "get",
            dataType: 'json',
            async:true,
            success: function(data){
                console.log(data);
                document.getElementById("product_details").innerHTML ="Product Code  :  "+data.product_code+"<br>Company Name  :  "+data.company_name+"<br>Available Amount  :  "+data.available_amount+"<br>Unit Price  :  "+data.unit_price;
                $("#product_details").show();
            },
            error: function(data)
            {
                console.log("error");
            }
        });

    });



    function addProduct(product_id,product_name,qty) {
        var HTML = "";
        var flag_isAlreadyAdded = false;
        console.log(products_on_order);
        if(product_id!='' && qty!=''){

            for(product in products_on_order){
                if(products_on_order[product].product_id==product_id){
                    products_on_order[product].qty=qty;
                    //document.getElementById("qty").innerHTML =qty;
                    flag_isAlreadyAdded = true;
                }
            }
            if(!flag_isAlreadyAdded) {
                products_on_order.push({product_id,product_name,qty});
            }
            for(product in products_on_order){
                HTML+="<div class='row'><div class='col-md-7'><div class='box box-success box-solid' style='margin-bottom: auto; height:50px;'><div class='box-header with-border' style='height:50px;'><h3 class='box-title'><h5 style='float:left'>"+products_on_order[product].product_name+"</h5><h5 style='float:right; margin-right:20%;'>"+products_on_order[product].qty+"</h5><div class='box-tools pull-right'><button type='button' class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div><div class='col-md-5'></div></div>";
                console.log(products_on_order);
                document.getElementById("products_on_order").innerHTML =HTML;
            }

        }
        else{

        }
    };

</script>
@endsection