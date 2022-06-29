@extends('admin_dashboard')
@section('admin_content')
<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  textarea {
    background: rgba(255,255,255,0.1);
    border: none;
    font-size: 16px;
    height: auto;
    margin: 0;
    outline: 0;
    padding: 15px;
    width: 100%;
    background-color: #e8eeef;
    color: #8a97a0;
    box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
    margin-bottom: 30px;
  }
</style>
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
    <h1 class="h3 mb-2 text-gray-800">TÁC GIẢ</h1> 
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách tác giả</h4>    
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i> Thêm tác giả</button>
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                        <strong>Thêm tác giả</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{URL::to('/add-author')}}" method="post">   
                                    {{ csrf_field() }}  
                                    <div class="modal-body">
                                        <label for="name" style="color: black;"> Tên tác giả:</label>
                                        <input type="text" id="add_name" name="user_name">
                                            
                                        <label for="phone" style="color: black;">Số điện thoại:</label>
                                        <input type="number" id="add_phone" name="user_phone" pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số.">
                                            
                                        <label for="email" style="color: black;">Email:</label>
                                        <input type="email" id="add_mail" name="user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ." ">             
                                                    
                                        <label for="story" style="color: black;">Tiểu sử:</label>
                                        <textarea id="add_story" name="story" ></textarea> 
                                        <label for="year" style="color: black;">Năm sinh:</label>
                                        <input type="number" id="add_year" name="year" min="1000" >  
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                        <button type="submit" class="btn btn-primary add" disabled>Lưu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Tên tác giả</th>
                                <th>Năm sinh</th> 
                                <th>Tiểu sử</th>
                                <th>Số điện thoại</th>
                                <th>Email</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên tác giả</th>
                                <th>Năm sinh</th> 
                                <th>Tiểu sử</th>
                                <th>Số điện thoại</th>
                                <th>Email</th> 
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($all_author as $keyAuthor => $eachAuthor)
                            <tr>
                                <td>{{$eachAuthor->author_name}}</td>
                                <td>{{$eachAuthor->author_birthday}}</td>
                                <td>{{$eachAuthor->author_story}}</td>
                                <td>{{$eachAuthor->author_phone}}</td>
                                <td>{{$eachAuthor->author_email}}</td>
                                <td>
                                    <button type="button" class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>                                    
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật tác giả</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-author/'.$eachAuthor->author_id)}}" method="post">
                                                    {{ csrf_field() }} 
                                                        <div class="modal-body">      
                                                            <label for="name" style="color: black;">Tên tác giả:</label>
                                                            <input type="text" id="name" name="user_name" value="{{$eachAuthor->author_name}}">
                                                            
                                                            <label for="phone" style="color: black;">Số điện thoại:</label>
                                                            <input type="text" id="phone" name="user_phone" >
                                                            
                                                            <label for="email" style="color: black;">Email:</label>
                                                            <input type="email" id="mail" name="user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ." value="{{$eachAuthor->author_email}}">             
                                                                    
                                                            <label for="story" style="color: black;">Tiểu sử:</label>
                                                            <textarea id="story" name="story">{{$eachAuthor->author_story}}</textarea> 
                                                            <label for="year" style="color: black;">Năm sinh:</label>
                                                            <input type="number" min="1000" id="year" name="year" value="{{$eachAuthor->author_birthday}}">  
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary" >Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-author/'.$eachAuthor->author_id)}}" method="post">
                                    {{ csrf_field() }} 
                                        <div class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa tác giả <strong> {{$eachAuthor->author_name}} </strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới tác giả này.</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Hủy bỏ</button>
                                                        <button type="submit" class="btn btn-danger" >Xóa</button>
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
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    $('#add_name').on('change',function(){
        $('#add_phone').on('change',function(){
            $('#add_mail').on('change',function(){
                $('#add_story').on('change',function(){
                    $('#add_year').on('change',function(){
                        var year = $(this).val();
                        var date = new Date();
                        var current_year = date.getFullYear();
                        if(year < 1000 || year > current_year || (year-current_year) < 18){
                            alert('Năm sinh phải lớn hơn 1000 và nhỏ hơn năm ' + current_year + ' và đủ 18 tuổi.');
                        } else {
                            $('.add').removeAttr('disabled');
                        }
                        });
                });
            });
        });
    });
</script>
@endsection
