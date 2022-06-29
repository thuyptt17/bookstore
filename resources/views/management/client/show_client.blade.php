@extends('admin_dashboard')
@section('admin_content')
<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="date"],
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
    <h1 class="h3 mb-2 text-gray-800">KHÁCH HÀNG</h1>    
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách khách hàng</h4>    
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                     Thêm khách hàng
                </button>
                    <div id="myModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                        <strong>Thêm khách hàng</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{URL::to('/add-client')}}" method="post">
                                {{ csrf_field() }} 
                                    <div class="modal-body">        
                                        <label for="name" style="color: black;">Tên khách hàng:</label>
                                        <input type="text" id="add_name" name="user_name">                        
                                        <label for="phone" style="color: black;">Số điện thoại:</label>
                                        <input type="text" id="add_phone" name="user_phone" pattern="[0]{1}[0-9]{9}" title="Số điện thoại phải bắt đầu bằng số 0 và có 10 chữ số."  >                          
                                        <label for="email" style="color: black;">Email:</label>
                                        <input type="email" id="add_email" name="user_email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}" title="Email không hợp lệ.">                                               
                                        <label for="address" style="color: black;">Địa chỉ:</label>
                                        <textarea id="add_address" name="address"></textarea> 
                                        <label for="type" style="color: black;">Loại khách hàng:</label>
                                        <select id="add_type" name="type">
                                            <option value="1">Thường</option>
                                            <option value="2">Vip</option>
                                        </select>
                                        <label for="birthday" style="color: black;">Sinh nhật:</label>
                                        <input type="date" id="add_birthday" name="birthday">  
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
                                <th>Tên khách hàng</th>
                                <th>SĐT</th>                              
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Sinh nhật</th>
                                <th>Loại khách hàng</th>
                                <th>Tổng nợ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên khách hàng</th>
                                <th>SĐT</th>                              
                                <th>Email</th>
                                <th>Địa chỉ</th>
                                <th>Sinh nhật</th>
                                <th>Loại khách hàng</th>
                                <th>Tổng nợ</th>
                                <th>Hành động</th>      
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($all_client as $keyClient => $eachClient)    
                            <tr>
                                <td>{{$eachClient->client_name}}</td>
                                <td>{{$eachClient->client_phone}}</td>
                                <td>{{$eachClient->client_email}}</td>
                                <td>{{$eachClient->client_address}}</td>
                                <td>{{Carbon\Carbon::parse($eachClient->client_birthday)->format('Y-m-d')}}</td>
                                @if($eachClient->client_type == 1)
                                    <td>Thường</td>
                                @else
                                    <td>Vip</td>
                                @endif
                                <td>{{number_format($eachClient->client_debt)}}đ</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white; ">Chỉnh sửa</button>
                                    <button type="button" class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật khách hàng</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-client/'.$eachClient->client_id)}}" method="post">
                                                    {{ csrf_field() }} 
                                                        <div class="modal-body">        
                                                            <label for="name" style="color: black;">Tên khách hàng:</label>
                                                            <input type="text" id="name" name="user_name" value="{{$eachClient->client_name}}">                        
                                                            <label for="phone" style="color: black;">Số điện thoại:</label>
                                                            <input type="text" id="phone" name="user_phone" value="{{$eachClient->client_phone}}">                          
                                                            <label for="email" style="color: black;">Email:</label>
                                                            <input type="email" id="email" name="user_email" value="{{$eachClient->client_email}}">                                               
                                                            <label for="address" style="color: black;">Địa chỉ:</label>
                                                            <textarea id="address" name="address">{{$eachClient->client_address}}</textarea> 
                                                            <label for="birthday" style="color: black;">Sinh nhật:</label>
                                                            <input type="date" id="birthday" name="birthday" value="{{Carbon\Carbon::parse($eachClient->client_birthday)->format('Y-m-d')}}">  
                                                            <label for="type" style="color: black;">Loại khách hàng:</label>
                                                            <select id="type" name="type">
                                                                @if($eachClient->client_type == 1)
                                                                    <option value="1" selected>Thường</option>
                                                                    <option value="2">Vip</option>
                                                                @else
                                                                    <option value="1">Thường</option>
                                                                    <option value="2" selected>Vip</option>
                                                                @endif
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
                                    <form action="{{URL::to('/delete-client/'.$eachClient->client_id)}}" method="post">
                                    {{ csrf_field() }} 
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc muốn xóa khách hàng <strong>{{$eachClient->client_name}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới khách hàng này.</p>
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
            $('#add_email').on('change',function(){
                $('#add_address').on('change',function(){
                    $('#add_type').on('change',function(){
                        $('#add_birthday').on('change',function(){
                            var date = new Date($(this).val());
                            var year = date.getFullYear(); 
                            var current_date = new Date();
                            var current_year = current_date.getFullYear();
                            if((current_year-year) < 18){
                                alert('Khách hàng phải đủ 18 tuổi');
                            } else {
                                $('.add').removeAttr('disabled');
                            }
                        });
                    });
                });
            });
        });
    });
</script>
@endsection
