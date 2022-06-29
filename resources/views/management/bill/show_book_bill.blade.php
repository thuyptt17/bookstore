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
    <h1 class="h3 mb-2 text-gray-800"  style="display: inline-block; ">Chọn sách lập hóa đơn</h1>
         <a href="{{URL::to('/show-bill-cart')}}" style="color: red; margin-top: -4px;">
            <button class="button" style="float: right;
                            margin-top: -6px;
                            font-size: 15px;
                            color: orangered;
                            font-weight: bold; ">Xem sách đã chọn ({{Cart::content()->count()}})</button>
         </a>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách các sách</h4>                   
                <!--<button type="button" id="addBook" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm sách
                </button>
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="color: black;">
                                        <strong>Thêm sách</strong>
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                            <form action="{{URL::to('/add-book')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }} 
                                <div class="modal-body">
                                    <fieldset>          
                                        <label for="bookname" style="color: black;font-size: 18px ">Tên sách:</label>
                                        <input type="text" id="bookname" name="bookname">
                                        
                                        <label for="author" style="color: black;font-size:  18px; ">Đầu sách:</label>                           
                                        <select id="add_title" name="title" style="margin-bottom: 30px;">
                                            <option value="">Chọn đầu sách</option>
                                            @foreach($all_title as $key =>$title)
                                                <option value="{{$title->title_id}}">{{$title->title_name}}</option>
                                            @endforeach
                                        </select> 

                                        <label for="img" style="color: black;font-size: 18px">Hình ảnh:</label>
                                        <input type="file" id="img" name="img">

                                        <label for="year" style="color: black;font-size: 18px">Năm PH:</label>
                                        <input type="number" id="name" name="year"> 

                                        <label for="edition" style="color: black;font-size: 18px">Lần xuất bản:</label>
                                        <input type="number" id="edition" name="edition"> 
                                        
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>-->
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Tên sách</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>SL Tồn</th>
                                <th>Giá bán</th>
                                <th>Hành động</th> 
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên sách</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>SL Tồn</th>
                                <th>Giá bán</th>
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_book as $key =>$book)
                            <tr>
                                <td>{{$book->book_name}}</td>
                                <td>{{$book->title_name}}</td>
                                <td>{{$book->year_publish}}</td>
                                <td>{{$book->stock}}</td>
                                <td>{{number_format($book->price). '(đ)'}}</td>
                               
                                <td>
                                    <form action="{{URL::to('/add-book-to-cart')}}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="product_id_hidden" value="{{$book->book_id}}" />
                                        <input type="hidden" name="product_cart_name" value="{{$book->book_name}}" />
                                        <input type="hidden" name="product_cart_price" value="{{$book->price}}" min="1">
                                        <input type="hidden" name="qty_cart" value="1" min="1"> 
                                        <button type="submit"  class="btn btn-lg btn-primary edit" 
                                            style="font-size: 15px;background-color: SeaGreen; color: white;">
                                            Thêm vào hóa đơn
                                        </button>
                                    </form> 
                                    
                                </td>
                            </tr>                  
                        @endforeach                                  
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Design my Website 2022</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
   
<Script>
    $(document).ready(function(){
        $("#addBook").click(function(){
            $("#myModal").modal("show");
        });
     
    });
</Script>

    
@endsection
