@extends('admin_dashboard')
@section('admin_content')

<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="file"],
  .modal-body select,
  textarea {
    background: rgba(255,255,255,0.1);
    border: 1px solid #ced4da;
    font-size: 16px;
    border-radius: 5px;
    width: 100%;
    height: 35px;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 5px;
  } 
  .button {
    background-color: #c2fbd7;
    border-radius: 100px;
    box-shadow: rgba(44, 187, 99, .2) 0 -25px 18px -14px inset,rgba(44, 187, 99, .15) 0 1px 2px,rgba(44, 187, 99, .15) 0 2px 4px,rgba(44, 187, 99, .15) 0 4px 8px,rgba(44, 187, 99, .15) 0 8px 16px,rgba(44, 187, 99, .15) 0 16px 32px;
    color: green;
    cursor: pointer;
    display: inline-block;
    font-family: CerebriSans-Regular,-apple-system,system-ui,Roboto,sans-serif;
    padding: 7px 20px;
    text-align: center;
    text-decoration: none;
    transition: all 250ms;
    border: 0;
    font-size: 16px;
    user-select: none;
    -webkit-user-select: none;
    touch-action: manipulation;
    }

    .button:hover {
    box-shadow: rgba(44,187,99,.35) 0 -25px 18px -14px inset,rgba(44,187,99,.25) 0 1px 2px,rgba(44,187,99,.25) 0 2px 4px,rgba(44,187,99,.25) 0 4px 8px,rgba(44,187,99,.25) 0 8px 16px,rgba(44,187,99,.25) 0 16px 32px;
    transform: scale(1.05) rotate(-1deg);
    }
</style>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800" style="display: inline-block; ">THÊM PHIẾU NHẬP SÁCH</h1>
    <form action="{{URL::to('/save-entry-money')}}" method="POST">
        {{ csrf_field() }}
        <button type="submit" id="print" class="btn btn-lg btn-primary button"
            style="font-size: 15px; color: black; float: right; margin-top: -4%;">Tạo
        </button> 
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div style="float: right;">
                    <h5 style="display: inline-block;">Tổng hóa đơn: </h5>
                    <?php
                        $total = str_replace(',','',Cart::subtotal());
                        $total_cart = floatval($total);                                         
                    ?>
                    <label type="text" style="width: 120px; height: 30px;margin-bottom: -6px; font-size: 17px;
                            font-weight: bold;" id="sum-total">
                        {{number_format($total_cart)}} 
                    </label>đ
                </div>
            </div>
                   
            <div class="card-body">
                <div class="table-responsive">
                <?php
                    $content = Cart::content();
                ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên sách</th>
                                <th>Giá nhập</th>
                                <th>SL Nhập</th>
                                <th>Tổng tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên sách</th>
                                <th>Giá nhập</th>
                                <th>SL Nhập</th>
                                <th>Tổng tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </tfoot>
                       
                            <tbody class="body_book_entry">
                                @foreach($content as $key => $v_content)
                                <?php
                                    $total = str_replace(',','',Cart::subtotal());
                                    $total_cart = floatval($total);                                         
                                ?>
                                <tr>                              
                                    <td class="product_name">{{$v_content->name}}</td>
                                    <td class="product-price-new">
                                        <input type="text" name="price" min=1 style="width: 100px; " 
                                        class="product-price" value={{$v_content->price}} > đ
                                    </td>
                                    <input type="hidden" name="cart_total" class="new_cart_total" value={{$total_cart}} >
                                                                
                                    <input class="product-price-value" type="hidden" value={{$v_content->price}}>
                                    <input class="product-row-id" type="hidden" value={{$v_content->rowId}}> 
                                    <input class="so_luong_nhap" type="hidden" value={{$regulation->SoLuongNhapToiThieu}}>                              
                                    <td class="product-quantity-cell" > 
                                        <button type="button" class="minus button">-</button>  
                                        <input class='product-quantity' type='text'  style="width: 60px;" min=1 value={{$v_content->qty}}> 
                                        <button type="button" class="plus button">+</button>              
                                    </td> 
                                    <td class="product-price">
                                        <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label> VNĐ</td>
                                    <td class="product_remove">
                                        <a href="{{URL::to('/delete-to-cart/'.$v_content->rowId)}}">
                                            <button class="btn btn-danger remove" type="button"><i class="fas fa-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach                      
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>   
        </form>        
    </div>
    <a href="{{URL::to('/show-all-book')}}" style="color: white;">
        <button type="button" 
        class="btn btn-lg btn-primary" 
        style="font-size: 15px;background-color: indigo; color: white; left: 20px ">
        
        <i class="fas fa-solid fa-plus" ></i>
            Thêm sách cần nhập
        </button> 
</a>   
     </div>
            <!-- End of Main Content -->
    </div>
        <!-- End of Content Wrapper --> 
</div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


<script>
    function calc_cart_total() {
        var sum = 0;
        var all_prices = $('.product-total');
        for(var i = 0; i < all_prices.length; i++)
        {
            sum += parseInt(all_prices[i].innerText.replaceAll(',', ''));
        }
        return sum;
    }
    $('.minus').click(function() {
        var row = $(this).parent().parent();
        var sl = parseInt(row.find('.so_luong_nhap').val());
        var quantity = parseInt(row.find('.product-quantity').val());
        if( quantity != 1 &&  (quantity >= sl)){
        var product_quantity = parseInt(row.find('.product-quantity').val()) - 1;
        row.find('.product-quantity').val(product_quantity);
        var product_price = parseInt(row.find(".product-price-value").val());
        if (product_price == '') {
            product_price = 0;
        }
        var product_total = product_price * product_quantity;
        var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
        var total = calc_cart_total() - old_product_total + product_total;   
        row.find(".product-total").text(product_total.toLocaleString("en-GB"));
        $('#sum-total').text(total.toLocaleString("en-GB"));
        row.find(".new_cart_total").val(total);
        $.ajax({
            url: "{{url('/update-cart-quantity')}}",
            method: "POST",
            data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    qty_cart: product_quantity,
                    _token: "{{ csrf_token() }}"
                }
            }); 
        
        } else {
            alert('Số lượng nhập tối thiểu theo qui định là' + sl + ' .Vui lòng nhập sách đúng qui định.')
        }
    });

    $('.plus').click(function(){
        var row = $(this).parent().parent();
        var sl = parseInt(row.find('.so_luong_nhap').val());
        var product_quantity = parseInt(row.find('.product-quantity').val()) + 1;
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt(row.find('.product-id-quantity').val());
        if(quanity < sl){
            alert('Số lượng nhập tối thiểu theo qui định là' + sl + ' .Vui lòng nhập sách đúng qui định.')
        }
        var product_price = parseInt(row.find(".product-price-value").val());
        if (product_price == '') {
                product_price = 0;
        }
        var product_total = product_price * product_quantity;
        var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
        var total = calc_cart_total() - old_product_total + product_total;
        row.find(".product-total").text(product_total.toLocaleString("en-GB"));
        $('#sum-total').text(total.toLocaleString("en-GB"));
        row.find(".new_cart_total").val(total);
        $.ajax({
            url: "{{url('/update-cart-quantity')}}",
            method: "POST",
            data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    qty_cart: product_quantity,
                    _token: "{{ csrf_token() }}"
                }
            });
    });

    $('.product-price').on('change',function(){
        var row = $(this).parent().parent();
        var product_quantity = parseInt(row.find('.product-quantity').val())
        var product_price = parseInt(row.find(".product-price").val());
        if(product_price <= 0){
            alert("Giá tiền nhập không hợp lệ");
        }else{
            var product_total = product_price *product_quantity;
            var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
            var total = calc_cart_total() - old_product_total + product_total;
            row.find(".product-total").text(product_total.toLocaleString("en-GB"));
            row.find(".product-price").val(product_price);
            $('#sum-total').text(total.toLocaleString("en-GB"));
            row.find(".new_cart_total").val(total);
            $.ajax({
            url: "{{url('/update-price')}}",
            method: "POST",
            data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    price: product_price,
                    _token: "{{ csrf_token() }}"
                }
            });
        }
    });

    $('.product-quantity').on('change',function(){
        var row = $(this).parent().parent();
        var sl = parseInt(row.find('.so_luong_nhap').val());
        var quantity = parseInt(row.find('.product-quantity').val());
        var product_price = parseInt(row.find(".product-price").val());
        if( quantity != 1 &&  (quantity >= sl)){
            row.find('.product-quantity').val( quantity);
            var product_total = product_price *  quantity;
            var old_product_total = parseInt(row.find(".product-total").text().replaceAll(',', ''));
            var total = calc_cart_total() - old_product_total + product_total;   
            row.find(".product-total").text(product_total.toLocaleString("en-GB"));
            row.find(".new_cart_total").val(total);
            $('#sum-total').text(total.toLocaleString("en-GB"));
            $.ajax({
                url: "{{url('/update-cart-quantity')}}",
                method: "POST",
                data: {
                        rowId_cart: row.find(".product-row-id").val(),
                        qty_cart:  quantity,
                        _token: "{{ csrf_token() }}"
                    }
                }); 
        
        } else {
            alert('Số lượng nhập tối thiểu theo qui định là' + sl + ' .Vui lòng nhập sách đúng qui định.')
        }
    });

</script>

   





@endsection
