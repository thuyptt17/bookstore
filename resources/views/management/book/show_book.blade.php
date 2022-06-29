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
</style>
<link rel="stylesheet" href="https://unpkg.com/@jarstone/dselect/dist/css/dselect.css">
<script src="https://unpkg.com/@jarstone/dselect/dist/js/dselect.js"></script>

<div class="container-fluid">
    <br />
    <?php
      $message = Session::get('message');
      if ($message)
      {
        ?>
            <div class="alert alert-success" id="divmessage" role="alert">
             <?php echo $message; ?>
             <button type="button" class="close" data-dismiss="alert" id="icon_hide_message" onclick="hidemessage()">×</button> 
            </div>
        <?php
        Session::put('message','');
      }
    ?>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Sách</h1>
    
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách các sách</h4>                   
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
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
                                        <input type="text" id="add_bookname" name="bookname">
                                        
                                        <label for="author" style="color: black;font-size:  18px; ">Đầu sách:</label>                           
                                        <select id="add_title" name="title" style="margin-bottom: 30px;">
                                            <option value="">Chọn đầu sách</option>
                                            @foreach($all_title as $key =>$title)
                                                <option value="{{$title->title_id}}">{{$title->title_name}}</option>
                                            @endforeach
                                        </select> 

                                        <label for="img" style="color: black;font-size: 18px">Hình ảnh:</label>
                                        <input type="file" id="add_img" name="img">

                                        <label for="edition" style="color: black;font-size: 18px">Lần xuất bản:</label>
                                        <input type="number" id="add_edition" name="edition" min="1"> 
                                        
                                        <label for="year" style="color: black;font-size: 18px">Năm PH:</label>
                                        <input type="number" id="add_year" name="year"> 

                                    
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button type="submit" class="btn btn-primary add" disabled>Lưu</button>
                                </div>
                            </div>
                        </form>
                        </div>
                    </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Tên sách</th>
                                <th>Hình ảnh</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>Giá bán</th>
                                <th>SL Tồn</th>
                                <th>Lần xuất bản</th>
                                <th>Hành động</th> 
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên sách</th>
                                <th>Hình ảnh</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>Giá bán</th>
                                <th>SL Tồn</th>
                                <th>Lần xuất bản</th>
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_book as $key =>$book)
                            <tr>
                                <td>{{$book->book_name}}</td>
                                <td style="width: 15%;">
                                    <img src="{{asset('resources/img/'.$book->image)}}" width="50%" height="50%">
                                </td>
                                <td>{{$book->title_name}}</td>
                                <td>{{$book->year_publish}}</td>
                                <td>{{number_format($book->price). '(đ)'}}</td>
                                <td>{{$book->stock}}</td>
                                <td>{{$book->edition}}</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;" >Xóa</button>
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật sách</strong>
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-book/'.$book->book_id)}}" method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                        <div class="modal-body">         
                                                            <label for="bookname" style="color: black;font-size: 18px ">Tên sách:</label>
                                                            <input type="text" id="bookname" name="bookname" value="{{$book->book_name}}">
                                                            
                                                            <label for="author" style="color: black;font-size:  18px; ">Đầu sách:</label>                           
                                                            <select class="edit_title" name="title" style="margin-bottom: 20px;">
                                                                <option value="">Chọn đầu sách</option>
                                                                @foreach($all_title as $key =>$title)
                                                                    <option value="{{$title->title_id}}" {{$title->title_id== $book->title_id ? 'selected' : '' }}>{{$title->title_name}}</option>
                                                                @endforeach
                                                            </select> 
                                                            
                                                            <div>
                                                                <label for="img" style="color: black;font-size: 18px;">Hình ảnh:</label>
                                                                <input type="file" id="img" name="img" >
                                                                <img src="{{asset('resources/img/'.$book->image)}}" width="50%" height="50%">
                                                            </div>
                                                            <label for="year" style="color: black;font-size: 18px">Năm PH:</label>
                                                            <input type="number" id="name" name="year" value="{{$book->year_publish}}"> 

                                                            <label for="price" style="color: black;font-size: 18px">Giá bán:</label>
                                                            <input type="number" id="price" name="price" value="{{$book->price}}"> 

                                                            <label for="stock" style="color: black;font-size: 18px">Số lượng tồn:</label>
                                                            <input type="number" id="stock" name="stock" value="{{$book->stock}}">
                                                            
                                                            <label for="edition" style="color: black;font-size: 18px">Lần xuất bản:</label>
                                                            <input type="number" id="edition" name="edition" value="{{$book->edition}}"> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-book/'.$book->book_id)}}" method="post">
                                    {{ csrf_field() }}
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc muốn xóa sách <strong>{{$book->book_name}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới sách này.</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button"  class="btn btn-secondary cancel" data-dismiss="modal">Hủy bỏ</button>
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>     
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



<script>
    
    $(document).ready(function(){
        $("#addAuthor").click(function(){
            $("#myModal").modal("show");
        });
     
    });

    $(document).ready(function(){
        $(".edit").click(function(){
            var row = $(this).parents('tr');  
            row.find(".editModal").modal("show");
        });
    });

    $(document).ready(function(){
        $(".delete").click(function(){
            var row = $(this).parents('tr'); 
            row.find(".deleteModal").modal("show");
        });

        $(".close").click(function(){
            var row = $(this).parents('tr'); 
            row.find(".deleteModal").modal("hide");
        });

        $(".cancel").click(function(){
            var row = $(this).parents('tr'); 
            row.find(".deleteModal").modal("hide");
        });
    });

</script>

<script>
    $(document).ready(function(){
        var select_title = document.querySelector('#add_title');
        dselect(select_title,{
            search: true
        });
    });
   
</script>
<script>
    $(document).ready(function(){
        var edit_title = document.querySelectorAll('select.edit_title');
        for(let i = 0; i < edit_title.length; i++){
            dselect(edit_title[i],{
                search: true
            });
        }
    });
    $('#add_bookname').on('change',function(){
        $('#add_title').on('change',function(){
            $('#add_edition').on('change',function(){
                var edition = $(this).val();
                
                if(edition <= 0 ){
                    alert('Lần xuất bản phải lơn hơn hoặc bằng 1.');
                }else{
                $('#add_year').on('change',function(){
                    var year = $(this).val();
                    var date = new Date();
                    var current_year = date.getFullYear();
                    if(year < 1000 || year > current_year){
                        alert('Năm phát hành phải lớn hơn 1000 và nhỏ hơn năm ' + current_year + '.');
                    } else {
                        $('.add').removeAttr('disabled');
                    }
                });
            }
            });
        

        });
    });
</script>
    
@endsection
