@extends('admin_dashboard')
@section('admin_content')

<div class="container-fluid">
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
    <h1 class="h3 mb-2 text-gray-800">PHIẾU NHẬP SÁCH</h1>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách phiếu nhập sách</h4>
                <a class="nav-link" href="{{URL::to('/show-all-book')}}">  
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-bs-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm phiếu nhập
                </button>
                </a>
            </div>
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Mã phiếu nhập</th>
                                <th>Ngày nhập sách</th> 
                                <th>Tổng tiền nhập</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mã phiếu nhập</th>
                                <th>Ngày nhập sách</th> 
                                <th>Tổng tiền nhập</th>
                                <th>Hành động</th>       
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($all_entry_money as $item)
                            <tr>
                                <td>PN0{{$item->entry_money_id}}</td>
                                <td>{{Carbon\Carbon::parse($item->date)->format('Y-m-d')}}</td>
                                <td>{{number_format($item->total)}} đ</td>
                                <td>
                                    <a href="{{URL::to('/show-detail-book-entry/'.$item->entry_money_id)}}" style="float:left;"> 
                                        <button type="button" class="btn btn-lg btn-primary edit" data-toggle="modal" style="font-size: 15px;background-color: SeaGreen; color: white;">Chi tiết</button>
                                    </a>
                                    <!--<button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                    <form action="{{URL::to('/delete-book-entry/'.$item->entry_money_id)}}" method="post">
                                    {{ csrf_field() }} 
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa phiếu nhập sách <strong>PN0{{$item->entry_money_id}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa phiếu nhập sách.</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button"  class="btn btn-secondary cancel" data-dismiss="modal">Hủy bỏ</button>
                                                        <button type="submit" class="btn btn-danger">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>     
                                    </form>  -->                             
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

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


</div>
<script>
    $(document).ready(function(){
        $("#addAuthor").click(function(){
            $("#myModal").modal("show");
        });
    });

    $(document).ready(function(){
        $("#edit").click(function(){
            $("#eidtModal").modal("show");
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
@endsection
