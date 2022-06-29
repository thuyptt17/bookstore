@extends('admin_dashboard')
@section('admin_content')
<style>
    .body{
    margin-top:10px;
    color: #484b51;
    }   
    .text-secondary-d1 {
        color: #728299!important;
    }
    .page-header {
        margin: 0 0 1rem;
        padding-bottom: 1rem;
        padding-top: .5rem;
        border-bottom: 1px dotted #e2e2e2;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-pack: justify;
        justify-content: space-between;
        -ms-flex-align: center;
        align-items: center;
    }
    .page-title {
        padding: 0;
        margin: 0;
        font-size: 1.75rem;
        font-weight: 300;
    }
    .brc-default-l1 {
        border-color: #dce9f0!important;
    }

    .ml-n1, .mx-n1 {
        margin-left: -.25rem!important;
    }
    .mr-n1, .mx-n1 {
        margin-right: -.25rem!important;
    }
    .mb-4, .my-4 {
        margin-bottom: 1.5rem!important;
    }

    hr {
        margin-top: 1rem;
        margin-bottom: 1rem;
        border: 0;
        border-top: 1px solid rgba(0,0,0,.1);
    }

    .text-grey-m2 {
        color: #888a8d!important;
    }

    .text-success-m2 {
        color: #86bd68!important;
    }

    .font-bolder, .text-600 {
        font-weight: 600!important;
    }

    .text-110 {
        font-size: 110%!important;
    }
    .text-blue {
        color: #478fcc!important;
    }
    .pb-25, .py-25 {
        padding-bottom: .75rem!important;
    }

    .pt-25, .py-25 {
        padding-top: .75rem!important;
    }
    .bgc-default-tp1 {
        background-color: rgba(121,169,197,.92)!important;
    }
    .bgc-default-l4, .bgc-h-default-l4:hover {
        background-color: #f3f8fa!important;
    }
    .page-header .page-tools {
        -ms-flex-item-align: end;
        align-self: flex-end;
    }

    .btn-light {
        color: #757984;
        background-color: #f5f6f9;
        border-color: #dddfe4;
    }
    .w-2 {
        width: 1rem;
    }

    .text-120 {
        font-size: 120%!important;
    }
    .text-primary-m1 {
        color: #4087d4!important;
    }

    .text-danger-m1 {
        color: #dd4949!important;
    }
    .text-blue-m2 {
        color: #68a3d5!important;
    }
    .text-150 {
        font-size: 150%!important;
    }
    .text-60 {
        font-size: 60%!important;
    }
    .text-grey-m1 {
        color: #7b7d81!important;
    }
    .align-bottom {
        vertical-align: bottom!important;
    }
</style>
<div class="container-fluid">
    <div class="page-content container">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                <a href="{{URL::to('/show-bill')}}"> Hóa đơn </a>
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    SHĐ: 0{{$bill->bill_id}}
                </small>
            </h1>

            <div class="page-tools">
                <div class="action-buttons">
                    <a class="btn bg-white btn-light mx-1px text-95"   href="{{URL::to('/export-bill/'.$bill->bill_id)}}" target='_blank'" data-title="Print" >
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        In
                    </a>
                </div>
            </div>
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <i class="fa fa-book fa-2x text-success-m2 mr-1"></i>
                                <span class="text-default-d3">Bootdey.com</span>
                            </div>
                        </div>
                    </div>

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">Khách hàng:</span>
                                <span class="text-600 text-110 text-blue align-middle">{{$client->client_name}}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    Địa chỉ: {{$client->client_address}}
                                </div>
                                <div class="my-1">
                                   Email: {{$client->client_email}}
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600"> {{$client->client_phone}}</b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Hóa đơn
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">SHĐ:</span> 0{{$bill->bill_id}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Ngày tạo:</span> {{$bill->bill_date}}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Tình trạng:</span> <span class="badge badge-warning badge-pill px-25">Đã thanh toán</span></div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                        <div class="row text-600 text-white bgc-default-tp1 py-25">
                            <div class="d-none d-sm-block col-1">#</div>
                            <div class="col-9 col-sm-5">Sản phẩm</div>
                            <div class="d-none d-sm-block col-4 col-sm-2">Số lượng</div>
                            <div class="d-none d-sm-block col-sm-2">Giá bán</div>
                            <div class="col-2">Tổng cộng</div>
                        </div>
                        <?php 
                            $i = 0;
                        ?>
                        <div class="text-95 text-secondary-d3">
                            @foreach($all_detail_bill as $detail_bill)
                            <div class="row mb-2 mb-sm -0 py-25">
                                <div class="d-none d-sm-block col-1">{{++$i}}</div>
                                @foreach($all_book as $book)
                                    @if($book->book_id == $detail_bill->book_id)
                                        <div class="col-9 col-sm-5">{{$book->book_name}}</div>
                                    @endif
                                @endforeach
                                <div class="d-none d-sm-block col-2">{{$detail_bill->quantity}}</div>
                                <div class="d-none d-sm-block col-2 text-95">{{number_format($detail_bill->price)}}đ</div>
                                <div class="col-2 text-secondary-d2">{{number_format($detail_bill->total)}}đ</div>
                            </div>    
                            @endforeach                  
                        </div>

                        <div class="row border-b-2 brc-default-l2"></div>

                        <div class="row mt-3" >
                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last" style="width: 500px; left: 700px; float: right; color: black; font-weight: bold;">
                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right" style="font-size: 20px;">
                                      Thành tiền: 
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">{{number_format($bill->bill_total)}}đ</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right" style="font-size: 20px;">
                                      Tiền trả: 
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">{{number_format($bill->bill_pay)}}đ</span>
                                    </div>
                                </div>
                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-7 text-right" style="font-size: 20px;">
                                      Tiền nợ: 
                                    </div>
                                    <div class="col-5">
                                        <span class="text-150 text-success-d3 opacity-2">{{number_format($bill->bill_total-$bill->bill_pay)}}đ</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
