@extends('admin_dashboard')
@section('admin_content')
<style> 
  input[type="text"],
  input[type="email"],
  input[type="number"],
  input[type="tel"],
  input[type="time"],
  input[type="date"],
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
<link rel="stylesheet" href="{{asset('https://unpkg.com/@jarstone/dselect/dist/css/dselect.css')}}">
<script src="{{asset('https://unpkg.com/@jarstone/dselect/dist/js/dselect.js')}}"></script>
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
    <h1 class="h3 mb-2 text-gray-800">PHIẾU THU TIỀN</h1>
                    <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block;">Danh sách phiếu thu tiền</h4>        
                <button type="button" id="add" class="btn btn-lg btn-primary" data-toggle="modal" style="font-size: 15px;background-color: indigo;; color: white; float: right"> <i class="fas fa-solid fa-plus" style="color: white;"></i>
                    Thêm phiếu thu tiền
                </button>
                <form action="{{URL::to('/add-entry-money')}}" method="POST">
                    {{ csrf_field() }}
                    <div id="addModal" class="modal fade" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" style="color: black;">
                                        <strong>Thêm phiếu thu tiền</strong>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <fieldset>          
                                        <label for="name" style="color: black;">Khách hàng:</label>
                                        <select id="add_client" name="name" >
                                            <option value="">Chọn khách hàng</option>
                                            @foreach($all_client as $client)
                                                <option value="{{$client->client_id}}">
                                                   Tên: {{$client->client_name}} - Nợ: {{number_format($client->client_debt)}}đ </option>
                                                
                                            @endforeach
                                        </select>                                                    
                                        <label for="money" style="color: black;">Số tiền thu:</label>
                                        <input type="number" id="money" name="money" min=1> 
                                        @foreach($all_client as $item)
                                            <input type="hidden" id="debt_{{$item->client_id}}" value="{{$item->client_debt}}"/>
                                        @endforeach
                                    </fieldset>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                                    <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Mã phiếu thu</th>
                                <th>Khách hàng</th>
                                <th>Ngày thu tiền</th> 
                                <th>Số tiền thu</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Mã phiếu thu</th>
                                <th>Khách hàng</th>
                                <th>Ngày thu tiền</th> 
                                <th>Số tiền thu</th>
                                <th>Hành động</th>      
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach($all_entry_money as $item)
                            <tr>
                                <td>PT0{{$item->debt_id}}</td>
                                @foreach($all_clients as $client)
                                    @if($item->client_id == $client->client_id)
                                        <td>{{$client->client_name}}</td>
                                    @endif
                                @endforeach
                                <td>{{$item->date}}</td>
                                <td>{{number_format($item->money)}}đ</td>
                                <td>
                                    <button type="button"  class="btn btn-lg btn-primary delete" data-toggle="modal" style="font-size: 15px;background-color: Crimson; color: white;">Xóa</button>
                                   
                                    <form action="{{URL::to('/delete-entry-money/'.$item->debt_id)}}" method="post">
                                    {{ csrf_field() }} 
                                        <div  class="modal fade deleteModal">
                                            <div class="modal-dialog modal-confirm">
                                                <div class="modal-content">
                                                    <div class="modal-header flex-column">
                                                        <div class="icon-box">
                                                            <i class="material-icons">&#xE5CD;</i>
                                                        </div>						
                                                        <h4 class="modal-title w-100">Bạn có chắc chắn muốn xóa PN0{{$item->debt_id}} này?</h4>	
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Nếu chọn "Xóa" sẽ xóa phiếu thu tiền.</p>
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

    <!-- Logout Modal-->
 
</div>
<script>
    $(document).ready(function(){
        $("#add").click(function(){
            $("#addModal").modal("show");
        });
    });

    $(document).ready(function(){
        $(".delete").click(function(){
            $(".deleteModal").modal("show");
        });

        $(".close").click(function(){
            $(".deleteModal").modal("hide");
        });

        $(".cancel").click(function(){
            $(".deleteModal").modal("hide");
        });
    });
    var select_client = document.querySelector('#add_client');
    dselect(select_client,{
        search: true
    });
    
    
    $('#add_client').on('change',function(){
        var id = $(this).val();
        var debt = parseInt($('#debt_'+id).val());
        $('#money').on('change',function(){
            var money = parseInt($('#money').val());
            if(money <= 0 || money > debt )
            {              
                alert('Số tiền thu vượt quá số tiền nợ ' + debt);
                $('#money').val(0);
            }
            
        });
    });
</script>
@endsection
