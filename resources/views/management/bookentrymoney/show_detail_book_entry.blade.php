@extends('admin_dashboard')
@section('admin_content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">CHI TIẾT PHIẾU NHẬP PN0{{$entry_book->entry_money_id}}</h1>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-primary" style="display: inline-block; float: left; ">Danh sách các sách nhập</h4>
                <div class="total" style="float: right;">
                    <h5 style="display: inline-block;">Tổng hóa đơn: {{number_format($entry_book->total)}} đ </h5>
                </div>
            </div>
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                         <thead>
                            <tr>
                                <th>Tên sách</th>
                                <th>SL Nhập</th>
                                <th>Giá nhập</th>
                                <th>Tổng tiền</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Tên sách</th>
                                <th>SL Nhập</th>
                                <th>Giá nhập</th>
                                <th>Tổng tiền</th>    
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($all_detail_entry as $item)
                            <tr>
                                <td>{{$item->book_name}}</td>
                                <td>{{$item->quantity}}</td>
                                <td>{{number_format($item->price)}} đ</td>
                                <td>{{number_format($item->total)}} đ</td>
                            </tr>  
                            @endforeach                                 
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Design my Website 2022</span>
            </div>
        </div>
     </footer>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->

</div>

@endsection
