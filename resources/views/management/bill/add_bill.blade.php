@extends('admin_dashboard')
@section('admin_content')

<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="file"],
  .modal-body input[type="date"],
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

  input[type="date"]{
    border: 1px solid #c4c4c4;
    border-radius: 5px;
    background-color: #fff;
    padding: 3px 5px;
    box-shadow: inset 0 3px 6px rgba(0,0,0,0.1);
    width: 190px;
  }
  .card .card-header .dropdown {
    line-height: 1;
    width: 300px;
  }

  .totals-item{
      display: flex;
  }

  .totals label{
    width: 185px;
    font-size: 20px;
    font-weight: bold;
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
<link rel="stylesheet" href="{{asset('https://unpkg.com/@jarstone/dselect/dist/css/dselect.css')}}">
<script src="{{asset('https://unpkg.com/@jarstone/dselect/dist/js/dselect.js')}}"></script>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800" style="display: inline-block; " >THÊM HÓA ĐƠN</h1>
    <form action="{{URL::to('/save-bill')}}" method="POST">
        {{ csrf_field() }}
        <button type="submit" id="print" class="button"
            style="font-size: 15px; color: black; float: right; margin-top: -4%;" disabled>Tạo
        </button> 
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <button type="button" id="addClient" class="btn btn-lg btn-primary" data-toggle="modal"
                 style="font-size: 15px;background-color: #4973ff;; color: white; float: right; box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);" >
                  <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm khách hàng mới
                </button>
                <div class="client">
                    <label for="client" style="color: black;font-size: 30px; ">Thông tin khách hàng</label>                           
                    <select id="add_client" name="client" style="margin-bottom: 30px;" >
                        <option value="">Chọn khách hàng</option>
                        @foreach($all_client as $item)
                            <option value="{{$item->client_id}}">{{$item->client_name}}</option>                           
                        @endforeach
                    </select> 
                    @foreach($all_client as $item)
                        <input type="hidden" id="debt_{{$item->client_id}}" value="{{$item->client_debt}}"/>
                    @endforeach
                       <input type="hidden" id="debt_max" value="{{$regulation->SoTienNoToiDa}}"/>
                </div>
                <form action="">
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                        <strong>Thêm khách hàng</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>          
                                        <label for="name" style="color: black;">Tên khách hàng:</label>
                                        <input type="text" id="name" name="user_name">                        
                                        <label for="phone" style="color: black;">Số điện thoại:</label>
                                        <input type="text" id="phone" name="user_phone">                          
                                        <label for="email" style="color: black;">Email:</label>
                                        <input type="email" id="mail" name="user_mail">                                               
                                        <label for="address" style="color: black;">Địa chỉ:</label>
                                        <textarea id="address" name="address"></textarea> 
                                        <label for="birthday" style="color: black;">Sinh nhật:</label>
                                        <input type="date" id="birthday" name="birthday">  
                                        <label for="type" style="color: black;">Loại khách hàng:</label>
                                        <select id="type" name="type">
                                            <option value="1">Thường</option>
                                            <option value="2">Vip</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button type="button" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
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
                                <th>Giá bán</th>
                                <th>Số Lượng</th>
                                <th>Tổng tiền</th>
                                <th>Xóa</th>
                            </tr>
                        </thead>
                            <input type="hidden" name="cart_total" id="sum">
                            <input type="hidden" name="payment" placeholder="0đ" id="pay-total">
                            <input type="hidden" name="still_total" placeholder="0đ" id="still"> 
                         
                                        
                            <tbody class="body_book_entry">
                                @foreach($content as $key => $v_content)
                                  
                                
                                <tr>                              
                                    <td class="product_name">{{$v_content->name}}</td>
                                    <td class="product-price-new">
                                        <input type="text" name="price" min=1 style="width: 100px; " 
                                        class="product-price" disabled  value={{number_format($v_content->price)}} > đ
                                    </td>
                                    @foreach($all_book as $item)
                                    @if($item->book_name == $v_content->name)
                                        <input type="hidden" class="book_stock" value="{{$item->stock}}"> 
                                    @endif 
                                @endforeach         
                                    <input class="product-price-value" type="hidden" value={{$v_content->price}}>
                                    <input class="product-row-id" type="hidden" value={{$v_content->rowId}}> 
                                    <td class="product-quantity-cell" > 
                                        <button type="button" class="minus button">-</button>  
                                        <input class='product-quantity' type='text'  style="width: 60px;" min=1 value={{$v_content->qty}}> 
                                        <button type="button" class="plus button">+</button>              
                                    </td> 
                                    <td class="product-price">
                                        <label class="product-total">{{number_format($v_content->price * $v_content->qty)}}</label> VNĐ</td>
                                    <td class="product_remove">
                                        <a href="{{URL::to('/delete-book-to-cart/'.$v_content->rowId)}}">
                                        <button class="btn btn-danger remove"><i class="fas fa-trash"></i></button>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach                                                  
                            </tbody>
                        </table>
                    </div>
                </div>          
            </div>
        </div>
        <a href="{{URL::to('/show-book-bill')}}" style="color: white;">
            <button type="button"  class="btn btn-lg btn-primary insert_new_row"  
                style="font-size: 15px;background-color: green; color: white; float: left;margin-left: 30px;
                    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);">
                
                <i class="fas fa-solid fa-plus" style="color: white;"></i>          
                    Thêm sách 
            </button>
        </a>
        <div class="totals" style="display: inline-block; float:right;">
            <div class="totals-item">
                <label>Thành tiền:</label>
                    <?php
                        $total = str_replace(',','',Cart::subtotal());
                        $total_cart = floatval($total);                                         
                    ?>
                <label style="width: 100px; height: 30px;margin-bottom: -6px;" id="sum-total">
                        {{number_format($total_cart)}}
                </label>đ
                
            </div>
            <div class="totals-item totals-item-total">
                <label>Số tiền trả:</label>
                <input type="number"  placeholder="0đ" id="pay_total">
            </div>
            <div class="totals-item totals-item-total">
                <label>Còn lại:</label>
                <label  style="width: 100px; height: 30px;margin-bottom: -6px;" id="still-total">0đ</label> 
                  
            </div>    
        </div>       
    </form>
        <!-- End of Content Wrapper --> 
</div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->


<script>
    $(document).ready(function(){ 
        $("#addClient").click(function(){
            $("#myModal").modal("show");
        });
       
        $(document).on('click','.remove',function(){
            $(this).parents('tr').remove();
        });
      
        $('.chooseBook').click(function(){  
            var row = $(this).parents('tr');            
            row.find('.chooseModal').modal("show");          
        });

        
    });  
</script>

<script>
    var select_client = document.querySelector('#add_client');
    dselect(select_client,{
        search: true
    });
</script>  

<script>
    $('#add_client').on('change',function(){
        $('#pay_total').on('change',function(){
            $('#print').removeAttr('disabled');
        });
    });
    $('#add_client').on('change',function(){
        var id = $(this).val();
        var debt = parseInt($('#debt_'+id).val());
        var debt_max = parseInt($('#debt_max').val());
        if(debt > debt_max ){
            alert('Khách hàng có số nợ vượt quá mức định');
        }
    });
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
        var quantity = parseInt(row.find('.product-quantity').val());
        if( quantity != 1){
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
        $.ajax({
            url: "{{url('/update-cart-quantity')}}",
            method: "POST",
            data: {
                    rowId_cart: row.find(".product-row-id").val(),
                    qty_cart: product_quantity,
                    _token: "{{ csrf_token() }}"
                }
            }); 
         }
    });

    $('.plus').click(function(){
        var row = $(this).parent().parent();
        var sl = parseInt(row.find('.book_stock').val());
        var product_quantity = parseInt(row.find('.product-quantity').val()) + 1;
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt(row.find('.product-id-quantity').val());
        if(product_quantity > sl){

            alert('Số lượng sách chỉ còn ' + sl + ' quyển sách.Vui lòng nhập số lượng nhỏ hơn.')
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

    $('.product-quantity').on('change',function(){
        var row = $(this).parent().parent();
        var sl = parseInt(row.find('.book_stock').val());
       
        var product_quantity = parseInt(row.find('.product-quantity').val());
        row.find('.product-quantity').val(product_quantity);
        var quanity = parseInt(row.find('.product-id-quantity').val());
        if(product_quantity > sl){
            alert('Số lượng sách chỉ còn ' + sl + ' quyển sách.Vui lòng chọn số lượng nhỏ hơn.')
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

    $('#pay_total').on('change', function(){
        var pay_total = $('#pay_total').val();
        var sum_total = calc_cart_total();
        if(pay_total <= sum_total && pay_total > 0){
            var still_total = sum_total - pay_total;
            $('#sum').val(sum_total);
            $('#still-total').text(still_total.toLocaleString("en-GB"));
            $('#pay-total').val(pay_total);
            $('#still').val((sum_total-pay_total));
        }
        else {
            alert('Số tiền trả phải nhỏ hơn tổng tiền và số tiền phải > 0.')
        }
    });

</script>
@endsection
