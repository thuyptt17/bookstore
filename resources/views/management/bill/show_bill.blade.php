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
    <h1 class="h3 mb-2 text-gray-800">HÓA ĐƠN</h1>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách  hóa đơn</h4>
                <a class="nav-link" href="{{URL::to('/show-book-bill')}}">  
                <button type="button" id="addAuthor" class="btn btn-lg btn-primary" data-bs-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm hóa đơn
                </button>
                </a>
            </div>
           
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Ngày tạo</th> 
                                <th>Khách hàng</th>
                                <th>Người tạo</th>
                                <th>Tổng hóa đơn</th>
                                <th>Tiền trả</th>
                                <th>Tiền nợ</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Ngày tạo</th> 
                                <th>Khách hàng</th>
                                <th>Người tạo</th>
                                <th>Tổng hóa đơn</th>
                                <th>Tiền trả</th>
                                <th>Tiền nợ</th>
                                <th>Hành động</th>      
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_bill as $item)
                            <tr>
                                <td>HĐ0{{$item->bill_id}}</td>
                                <td>{{Carbon\Carbon::parse($item->bill_date)->format('Y-m-d')}}</td>
                                @foreach($all_client as $client)
                                    @if($item->client_id == $client->client_id)
                                        <td>{{$client->client_name}}</td>
                                    @endif
                                @endforeach
                                @foreach($all_staff as $eachstaff)
                                    @if($item->staff_id == $eachstaff->staff_id)
                                        <td>{{$eachstaff->staff_name}}</td>
                                    @endif
                                @endforeach
                                <td>{{number_format($item->bill_total)}}đ</td>
                                <td>{{number_format($item->bill_pay)}}đ</td>
                                <td>{{number_format($item->bill_total-$item->bill_pay)}}đ</td>
                                <td>
                                    <a class="nav-link" href="{{URL::to('/show-detail-bill/'.$item->bill_id)}}" style="float:left;"> 
                                        <button type="button" id="edit" class="btn btn-lg btn-primary" 
                                        style="font-size: 15px;background-color: SeaGreen; color: white;">Chi tiết
                                        </button>
                                    </a>
                                    <a href="{{URL::to('/export-bill/'.$item->bill_id)}}" target='_blank'>
                                        <button type="button" id="print" class="btn btn-lg btn-primary"
                                        style="font-size: 15px;background-color: blue; color: white; margin-top: 8px; margin-left: 10px;">In
                                        </button>  
                                    </a>
                                    <!--<button type="button" class="btn btn-lg btn-primary delete"
                                     style="font-size: 15px;background-color: Crimson; color: white; margin-top: 8px;">Xóa
                                    </button>
                                    

                                    <form action="{{URL::to('/delete-bill/'.$item->bill_id)}}" method="post">
                                        {{ csrf_field() }} 
                                        <div  class="modal fade deleteModal" >
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa <strong>HĐ0{{$item->bill_id}}</strong> này không?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa hóa đơn.</p>
                                                    </div>
                                                    <div class="modal-footer justify-content-center">
                                                        <button type="button" class="btn btn-secondary cancel" data-dismiss="modal">Hủy bỏ</button>
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

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div> 
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
