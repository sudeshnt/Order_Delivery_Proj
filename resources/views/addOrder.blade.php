@extends('master')

@section('content')

    <style>
        .row1 {
            margin:-2%;
        }
    </style>

<div class="panel">
    {{--<form role="form" method="post" action="{{ url('/addOrder') }}">--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="box-body">
            <div class="row" style="margin-bottom: auto;">

                   {{-- <div class="form-group">
                        <label for="order_date">Date</label>
                        <input type="text" name="order_date" id="order_date" class="form-control pull-right" id="datepicker">
                    </div>--}}
                    {{--datetime picker--}}
                        <div class="row">
                            <div class='col-sm-4'>
                                <div class="form-group">
                                    <label for="order_date">Order ID</label>
                                    <div class='input-group date'>
                                        <input type='text' class="form-control"  name='order_date' id='order_date'/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group">
                                        <label for="order_id">Order ID</label>
                                        <div class='input-group'>
                                            <input type="text" class="form-control" name="order_id" id="order_id"  required />
                                                <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-random" onclick="javascript:setOrderId();"></span>
                                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

            </div>
            <div class="row col-md-9" style="margin-top:-1%;">
                <div class="input-group row">
                    <label >Customer</label>
                    <select class="form-control select2" name="customer_id" id='customer_id' style="width: 100%;">
                        <option selected>Choose a Customer</option>
                        @foreach ($allCustomers as $customer)
                            <option value="{{$customer->customer_id}}">{{$customer->customer_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group row">
                    <label >Add Products</label>
                      <span>
                    {{--<button class="btn btn-primary" >--}}<span class="glyphicon glyphicon-plus-sign" style="font-size: 2em;margin-left: 1%;" id="add"></span>{{--</button>--}}
                      </span>
                </div>
                <div class="row" id="products_table_div">

                </div>
                <div class="row">
                    <label>Paid Amount</label>
                    <div class='input-group col-md-5'>
                        <input type="text" class="form-control" name="paid_amount" id="paid_amount"  required />
                        <span class="input-group-addon">
                                <span class="glyphicon glyphicon-usd"></span>
                        </span>
                        <span>
                            <select class="form-control" name="ispaid" id="ispaid" style="width: 110%;">
                                   <option value=true selected>Select Payment Option</option>
                                    <option value=true>Full Payment</option>
                                    <option value=false>Partial Payment</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="box-footer">
                    <button class="btn btn-primary" onclick="placeOrder();"> Place Order</button>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

    {{--</form>--}}
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
                                <select class="form-control product_details select2" name="product_id" id="product_id" style="width: 100%;">
                                        <option selected>Select Products</option>
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

                            <label for="price">Unit Price</label>
                            <input type="text" class="form-control" name="price" id="price" disabled>
                        </div>
                         <div><button class="btn btn-primary" style="margin-left: 2%" onclick="addProduct(document.getElementById('product_id').value,document.getElementById('product_id').options[document.getElementById('product_id').selectedIndex].text,document.getElementById('qty').value)">Add</button></div>

                        <div id="products_on_order">

                        </div>

                        <div>
                            <div class ="row" style='float:right; margin-bottom: -4%;'>
                                    <div id="total_amount">

                                    </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer">
                            <button type="button" class="btn btn-primary" onclick="generate_products_table();" style="margin-bottom: -3%">Save List</button>
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



    $( "#add" ).click(function() {
        $('#myModal').modal('show');
    });
    $('#order_date').datetimepicker({
        defaultDate: new Date(),
    });

    var products_on_order = [];
    var total_amount = 0;

    function setOrderId(){
        var rand = Math.floor((Math.random() * 1000000)+1);
        document.getElementById('order_id').value = 'O-'+("000000" + rand).slice(-6);
    }

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
                document.getElementById("price").value = data.unit_price;
                $("#product_details").show();
            },
            error: function(data)
            {
                console.log("error");
            }
        });

    });

    //when changing to full payment automatically set paid amount to full amount
    $( "#ispaid" ).change(function() {
        if($( "#ispaid").val()=='true'){
            document.getElementById("paid_amount").value = total_amount;
        }
    });




    function addProduct(product_id,product_name,qty) {
        var HTML = "";
        var flag_isAlreadyAdded = false;

        console.log(products_on_order);
        if(product_id!='' && qty!=''){

            for(product in products_on_order){
                if(products_on_order[product].product_id==product_id){
                    products_on_order[product].qty=qty;
                    products_on_order[product].price=document.getElementById("price").value*qty;
                    //products_on_order[product].unit_price=products_on_order[product].qty*document.getElementById("price").value;
                    //document.getElementById("qty").innerHTML =qty;
                    flag_isAlreadyAdded = true;
                }
            }
            if(!flag_isAlreadyAdded) {
                products_on_order.push({product_id,product_name,qty,price:document.getElementById("price").value*qty});
                console.log(products_on_order);
            }
            total_amount=0;
            for(product in products_on_order){
                total_amount+=products_on_order[product].price;
                HTML+="<div class='row'><div class='col-md-7'><div class='box box-success box-solid' style='margin-bottom: auto; height:50px;'><div class='box-header with-border' style='height:50px;'><h3 class='box-title'><h5 style='float:left'>"+products_on_order[product].product_name+"</h5><h5 style='float:right; margin-right:10%;'>"+products_on_order[product].price+" $</h5><h5 style='float:right; margin-right:10%;'>x"+products_on_order[product].qty+"</h5><div class='box-tools pull-right'><button type='button' class='btn btn-box-tool' onclick='removeProduct("+product+");' data-widget='remove'><i class='fa fa-times'></i></button></div></div></div></div><div class='col-md-5'></div></div>";
                document.getElementById("products_on_order").innerHTML =HTML;
            }
            document.getElementById("total_amount").innerHTML ='<h3>Total = '+total_amount+' $</h3>';
            console.log(total_amount);
        }
        else{

        }
    };

    function removeProduct(product){
                total_amount-=products_on_order[product].price;
                document.getElementById("total_amount").innerHTML ='<h3>Total = '+total_amount+' $</h3>';
                products_on_order.splice(product, 1);
                console.log(products_on_order);
    };

    function generate_products_table(){
        var table_content = '<table id="products_table"  class="table table-bordered table-hover allTables"><thead><tr><th>Product Name</th><th>Quantity</th><th>Price</th></tr> </thead><tbody>';
        for(product in products_on_order){
            table_content+='<tr><td>'+products_on_order[product].product_name+'</td><td>x '+products_on_order[product].qty+'</td><td>'+products_on_order[product].price+' $</td></tr>';
        }
        table_content+='<tr><td></td><td>Total</td><td>'+total_amount+' $</td></tr>'
        table_content+='</tbody></table>';
        document.getElementById("products_table_div").innerHTML =table_content;
        console.log(products_on_order);
    }

    //place order
    function placeOrder(){
        $.ajax({
            url: "{{ url('/placeOrder') }}",
            type: "get",
            data:{products_on_order:products_on_order,
                  order_date:document.getElementById("order_date").value,
                  order_code:document.getElementById("order_id").value,
                  customer_id:document.getElementById("customer_id").value,
                  paid_amount:document.getElementById("paid_amount").value,
                  isPaid:document.getElementById("ispaid").value,
                  full_amount:total_amount },
            dataType: 'json',
            async:true,
            success: function(data){
                window.location="{{URL::to('/invoice')}}/"+data;
            },
            error: function(data)
            {
                console.log("error");
            }
        });
    }

</script>
@endsection