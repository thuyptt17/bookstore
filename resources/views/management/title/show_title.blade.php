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
    <h1 class="h3 mb-2 text-gray-800">Đầu sách</h1>
    
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách đầu sách</h4>                   
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm đầu sách
                </button>
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" style="color: black;">
                                        <strong>Thêm đầu sách</strong>
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                            <form action="{{URL::to('/add-title')}}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }} 
                                <div class="modal-body">
                                    <fieldset>          
                                        <label for="bookname" style="color: black;font-size: 18px ">Tên đầu sách:</label>
                                        <input type="text" id="add_bookname" name="bookname">
                                        
                                        <label for="author" style="color: black;font-size:  18px; ">Tác giả:</label>                           
                                        <select id="add_author" name="author[]" style="margin-bottom: 30px;" multiple>
                                            <option value="">Chọn tác giả</option>
                                            @foreach($all_author as $key =>$author)
                                                <option value="{{$author->author_id}}">{{$author->author_name}}</option>
                                            @endforeach
                                        </select> 

                                        <label for="type" style="color: black; font-size: 18px">Thể loại:</label>
                                        <select id="add_category" name="type" style="margin-bottom: 30px;">
                                            <option value="">Chọn thể loại</option>
                                            @foreach($all_category as $key =>$category)
                                                <option value="{{$category->category_id}}">{{$category->category_name}}</option>
                                            @endforeach
                                        </select> 
                                        
                                        <label for="publisher" style="color: black;font-size: 18px">Nhà xuất bản:</label>
                                        <select id="add_publisher" name="publisher" style="margin-bottom: 30px;">
                                            <option value="">Chọn nhà xuất bản</option>
                                            @foreach($all_publisher as $key =>$publisher)
                                                <option value="{{$publisher->publisher_id}}">{{$publisher->publisher_name}}</option>
                                            @endforeach
                                        </select> 

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
                                <th>Tên đầu sách</th>
                                <th>Tác giả</th>
                                <th>Thể loại</th>
                                <th>Nhà xuất bản</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên đầu sách</th>
                                <th>Tác giả</th>
                                <th>Thể loại</th>
                                <th>Nhà xuất bản</th>
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_title as $key =>$title)
                            <tr>
                                <td>{{$title->title_name}}</td>
                                <td>
                                    @foreach($all_detail_author as $each)
                                        @if($title->title_id == $each->title_id)
                                            <ul>
                                                <li>{{$each->author_name}}</li>
                                            </ul>     
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$title->category_name}}</td>
                                <td>{{$title->publisher_name}}</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật đầu sách</strong>
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-title/'.$title->title_id)}}" method="post" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                        <div class="modal-body">         
                                                            <label for="bookname" style="color: black;font-size: 18px ">Tên đầu sách:</label>
                                                            <input type="text" id="bookname" name="bookname" value="{{$title->title_name}}">

                                                            <label for="type" style="color: black; font-size: 18px">Tác giả:</label>
                                                            <select class="edit_author" name="author[]" style="margin-bottom: 20px;"  multiple="multiple">
                                                                <option value="">Chọn tác giả</option>
                                                                @foreach($all_author as $key =>$author)
                                                                    <option value="{{$author->author_id}}" 
                                                                        @foreach($all_detail_author as $each)
                                                                            @if($each->title_id == $title->title_id)
                                                                             {{$each->author_id == $author->author_id ? 'selected': ''}}
                                                                            @endif
                                                                        @endforeach
                                                                    >
                                                                         {{$author->author_name}}
                                                                    </option>
                                                                @endforeach
                                                            </select>                         
                                                                          
                                                            <label for="type" style="color: black; font-size: 18px">Thể loại:</label>
                                                            <select class="edit_category" name="type" style="margin-bottom: 20px;">
                                                                <option value="">Chọn thể loại</option>
                                                                @foreach($all_category as $key =>$category)
                                                                    <option value="{{$category->category_id}}"  {{$category->category_id== $title->category_id ? 'selected' : '' }}>{{$category->category_name}}</option>
                                                                @endforeach
                                                            </select> 
                                                                                    
                                                            <label for="publisher" style="color: black;font-size: 18px">Nhà xuất bản:</label>
                                                            <select class="edit_publisher" name="publisher" style="margin-bottom: 20px;">
                                                                <option value="">Chọn nhà xuất bản</option>
                                                                @foreach($all_publisher as $key =>$publisher)
                                                                    <option value="{{$publisher->publisher_id}}"  {{$publisher->publisher_id== $title->publisher_id ? 'selected' : '' }}>{{$publisher->publisher_name}}</option>
                                                                @endforeach
                                                            </select> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-title/'.$title->title_id)}}" method="post">
                                    {{ csrf_field() }}
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa tác giả <strong> {{$title->title_name}} </strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới đầu sách này.</p>
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
        var select_author = document.querySelector('#add_author');
        dselect(select_author,{
            search: true
        });
        var select_category = document.querySelector('#add_category');
        dselect(select_category,{
            search: true
        });
        var select_publisher = document.querySelector('#add_publisher');
        dselect(select_publisher,{
            search: true
        });
    });
   
</script>
<script>
    $(document).ready(function(){
        var edit_author = document.querySelectorAll('select.edit_author');
        for(let i = 0; i < edit_author.length; i++){
            dselect(edit_author[i],{
                search: true
            });
        }

        var edit_category = document.querySelectorAll('select.edit_category');
        for(let i = 0; i < edit_category.length; i++){
            dselect(edit_category[i],{
                search: true
            });
        }

        var edit_publisher = document.querySelectorAll('select.edit_publisher');
        for(let i = 0; i < edit_publisher.length; i++){
            dselect(edit_publisher[i],{
                search: true
            });
        }
    });

    $('#add_bookname').on('change',function(){
        $('#add_author').on('change',function(){
            $('#add_category').on('change',function(){
                $('#add_publisher').on('change',function(){
                    $('.add').removeAttr('disabled');
                });
            });
        });
    });

</script>
    
@endsection
