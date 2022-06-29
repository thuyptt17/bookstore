@extends('admin_dashboard')
@section('admin_content')
<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="date"],
  input[type="password"],
  .modal-body input[type="search"],
  .modal-body select,
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
    <h1 class="h3 mb-2 text-gray-800">NHÂN VIÊN</h1>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách nhân viên</h4>
                <button type="button" id="add" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm nhân viên
                </button>
                    <div id="addModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                    <strong>Thêm nhân viên</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{URL::to('/add-staff')}}" method="post">
                                {{ csrf_field() }} 
                                    <div class="modal-body">
                                        <fieldset>          
                                            <label for="name" style="color: black;">Tên nhân viên:</label>
                                            <input type="text" id="add_name" name="name">

                                            <label for="address" style="color: black;">Địa chỉ:</label>
                                            <input type="text" id="add_address" name="address">
                                            
                                            <label for="phone" style="color: black;">SĐT:</label>
                                            <input type="number" id="add_phone" name="phone" pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số.">

                                            <label for="email" style="color: black;">Email:</label>
                                            <input type="email" id="add_email" name="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ.">
                                            <label for="position" style="color: black;">Chức vụ:</label>
                                            <select id="add_position" name="position">
                                                <option value="">Chọn chức vụ</option>
                                                <option value="1">Bán hàng</option>
                                                <option value="2">Kiểm kho</option>
                                                <option value="3">Quản lí</option>
                                            </select> 
                                            <label for="salary" style="color: black;">Lương:</label>
                                            <input type="number" id="add_salary" name="salary" min="1000"  pattern="[0-9]+" title="Giá tiền không hợp lệ"> 
                                            <label for="date" style="color: black;">Ngày vào làm:</label>
                                            <input type="date" id="add_date" name="date">
                                            
                                        </fieldset>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                        <button type="submit" class="btn btn-primary">Lưu</button>
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
                                <th>Tên nhân viên</th>
                                <th>Địa chỉ</th>
                                <th>SĐT</th> 
                                <th>Email</th>
                                <th>Ngày vào làm</th>
                                <th>Chức vụ</th>
                                <th>Lương</th>
                                <th>Mật khẩu</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên nhân viên</th>
                                <th>Địa chỉ</th>
                                <th>SĐT</th> 
                                <th>Email</th>
                                <th>Ngày vào làm</th>
                                <th>Chức vụ</th>
                                <th>Lương</th>
                                <th>Mật khẩu</th>
                                <th>Hành động</th>      
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_staff as $key =>$item)
                            <tr>
                                <td>{{$item->staff_name}}</td>
                                <td>{{$item->staff_address}}</td>
                                <td>{{$item->staff_phone}}</td>
                                <td>{{$item->staff_email}}</td>
                                <td>{{Carbon\Carbon::parse($item->staff_startdate)->format('Y-m-d')}}</td>
                                @if($item->staff_position == 1)
                                    <td>Bán hàng</td>
                                @elseif($item->staff_position == 2)
                                    <td>Kiểm kho</td>
                                @else
                                    <td>Quản lí</td>
                                @endif
                                <td>{{number_format($item->staff_salary). '(đ)'}}</td>
                                <td>{{$item->staff_password}}</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button" class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật nhân viên</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-staff/'.$item->staff_id)}}" method="post">
                                                    {{ csrf_field() }} 
                                                        <div class="modal-body">
                                                            <fieldset>          
                                                                <label for="name" style="color: black;">Tên nhân viên:</label>
                                                                <input type="text" id="name" name="name" value="{{$item->staff_name}}">

                                                                <label for="address" style="color: black;">Địa chỉ:</label>
                                                                <input type="text" id="address" name="address" value="{{$item->staff_address}}">
                                                                
                                                                <label for="phone" style="color: black;">SĐT:</label>
                                                                <input type="number" id="phone" name="phone" value="{{$item->staff_phone}}">

                                                                <label for="email" style="color: black;">Email:</label>
                                                                <input type="email" id="email" name="email" value="{{$item->staff_email}}">

                                                                <label for="date" style="color: black;">Ngày vào làm:</label>
                                                                <input type="date" id="date" name="date" value="{{Carbon\Carbon::parse($item->staff_startdate)->format('Y-m-d')}}">
                                                                
                                                                <label for="position" style="color: black;">Chức vụ:</label>
                                                                <select id="position" name="position">
                                                                    <option value="">Chọn chức vụ</option>
                                                                    @if($item->staff_position == 1)
                                                                        <option value="1" selected>Bán hàng</option>
                                                                        <option value="2">Kiểm kho</option>
                                                                        <option value="3">Quản lí</option>
                                                                    @elseif($item->staff_position == 2)
                                                                        <option value="1" >Bán hàng</option>
                                                                        <option value="2" selected>Kiểm kho</option>
                                                                        <option value="3">Quản lí</option>
                                                                    @else
                                                                        <option value="1">Bán hàng</option>
                                                                        <option value="2">Kiểm kho</option>
                                                                        <option value="3" selected>Quản lí</option>
                                                                    @endif
                                                                </select> 

                                                                <label for="salary" style="color: black;">Lương:</label>
                                                                <input type="number" id="salary" name="salary" value="{{$item->staff_salary}}"> 

                                                                <label for="password" style="color: black;">Mật khẩu:</label>
                                                                <input type="password" id="password" name="password" value="{{$item->staff_password}}">
                                                            </fieldset>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary">Lưu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-staff/'.$item->staff_id)}}" method="post">
                                    {{ csrf_field() }} 
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn muốn xóa nhân viên <strong>{{$item->staff_name}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới nhân viên này.</p>
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
                    $('#add_position').on('change',function(){
                        $('#add_salary').on('change',function(){
                            
                            $('#add_birthday').on('change',function(){
                                var date = new Date($(this).val());
                                var year = date.getFullYear(); 
                                var current_date = new Date();
                                var current_year = current_date.getFullYear();
                                if((current_year-year) < 18){
                                    alert('Khách hàng phải đủ 18 tuổi');
                                }
                                else {
                                    $('.add').removeAttr('disabled');
                                }
                            });
                        });
                    });
                });
            });
        });
    });

</script>
@endsection
