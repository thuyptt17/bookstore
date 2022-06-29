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
    <h1 class="h3 mb-2 text-gray-800">Thể loại sách</h1>
    
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách thể loại</h4>
                      
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm thể loại
                </button>
                <div id="myModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" style="color: black;">
                                <strong>Thêm thể loại</strong>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{URL::to('/add-category')}}" method="post">
                        {{ csrf_field() }}  
                            <div class="modal-body">       
                                <label for="name" style="color: black;">Tên thể loại:</label>
                                <input type="text" id="add_name" name="user_name">                                     
                                <label for="describe" style="color: black;">Mô tả:</label>
                                <textarea id="add_describe" name="describe"></textarea> 
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
                                <th>Tên thể loại</th>
                                <th>Mô tả</th> 
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên thể loại</th>
                                <th>Mô tả</th>
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($all_category as $keyCategory => $eachCategory)    
                            <tr>
                                <td>{{$eachCategory->category_name}}</td>
                                <td>{{$eachCategory->category_desc}}</td>
                                <td>
                                    <button type="button" class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chỉnh sửa</button>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                        <div  class="modal fade editModal" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" style="color: black;">
                                                            <strong>Cập nhật thể loại</strong>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{URL::to('/update-category/'.$eachCategory->category_id)}}" method="post">
                                                    {{ csrf_field() }}  
                                                        <div class="modal-body">
                                                            <label for="name" style="color: black;">Tên thể loại:</label>
                                                            <input type="text" id="name" name="user_name" value="{{$eachCategory->category_name}}">                                     
                                                            <label for="describe" style="color: black;">Mô tả:</label>
                                                            <textarea id="describe" name="describe">{{$eachCategory->category_desc}}</textarea> 
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    <form action="{{URL::to('/delete-category/'.$eachCategory->category_id)}}" method="post">
                                    {{ csrf_field() }}  
                                        <div class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa thể loại <strong>{{$eachCategory->category_name}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hết những thông tin liên quan tới thể loại này.</p>
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

        $('#add_name').on('change',function(){
            $('#add_describe').on('change',function(){
                $('.add').removeAttr('disabled');
            });
        });
    });
   
</script>
@endsection
