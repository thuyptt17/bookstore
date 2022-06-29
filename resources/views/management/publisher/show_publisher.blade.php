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
    <h1 class="h3 mb-2 text-gray-800">NHÀ XUẤT BẢN</h1>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách nhà xuất bản</h4>    
                <button type="button" id="add" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm nhà xuất bản
                </button>
                    <div id="addModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                    <strong>Thêm nhà xuất bản</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{URL::to('/add-publisher')}}" method="post">   
                                    {{ csrf_field() }}
                                    <div class="modal-body">       
                                        <label for="name" style="color: black;">Tên nhà xuất bản:</label>
                                        <input type="text" id="add_name" name="user_name">
                                            
                                        <label for="phone" style="color: black;">Số điện thoại:</label>
                                        <input type="text" id="add_phone" name="user_phone" pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số.">
                                            
                                        <label for="email" style="color: black;">Email:</label>
                                        <input type="email" id="add_email" name="user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ.">             
                                                    
                                        <label for="address" style="color: black;">Địa chỉ:</label>
                                        <textarea id="add_address" name="address"></textarea> 
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
                                <th>Tên nhà xuất bản</th>
                                <th>Số điện thoại</th> 
                                <th>Địa chỉ</th>
                                <th>Email</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                       
                            <tr>
                                <th>Tên nhà xuất bản</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Email</th> 
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($all_publisher as $keyPublisher => $eachPublisher)
                            <tr>
                                <td>{{$eachPublisher->publisher_name}}</td>
                                <td>{{$eachPublisher->publisher_phone}}</td>
                                <td>{{$eachPublisher->publisher_address}}</td>
                                <td>{{$eachPublisher->publisher_email}}</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                        <div class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật nhà xuất bản</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-publisher/'.$eachPublisher->publisher_id)}}" method="post">   
                                                        {{ csrf_field() }}
                                                        <div class="modal-body">       
                                                            <label for="name" style="color: black;">Tên nhà xuất bản:</label>
                                                            <input type="text" id="name" name="user_name" value="{{$eachPublisher->publisher_name}}">
                                                                
                                                            <label for="phone" style="color: black;">Số điện thoại:</label>
                                                            <input type="text" id="phone" name="user_phone" pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số." value="{{$eachPublisher->publisher_phone}}">
                                                                
                                                            <label for="email" style="color: black;">Email:</label>
                                                            <input type="email" id="email" name="user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ." value="{{$eachPublisher->publisher_email}}">             
                                                                        
                                                            <label for="address" style="color: black;">Địa chỉ:</label>
                                                            <textarea id="address" name="address">{{$eachPublisher->publisher_address}}</textarea> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-publisher/'.$eachPublisher->publisher_id)}}" method="post">
                                    {{ csrf_field() }}
                                        <div class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa nhà xuất bản <strong>{{$eachPublisher->publisher_name}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới nhà xuất bản này.</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Hủy bỏ</button>
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
        $("#add").click(function(){
            $("#addModal").modal("show");
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
            $('#add_email').on('change',function(){
                $('#add_address').on('change',function(){             
                    $('.add').removeAttr('disabled');      
                });
            });
        });
    });

</script>
@endsection
