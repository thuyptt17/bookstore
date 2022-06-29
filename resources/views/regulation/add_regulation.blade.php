@extends('admin_dashboard')
@section('admin_content')

<div class="container-fluid" style>
    <br />
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">THAY ĐỔI QUI ĐỊNH</h1>
        <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" method="POST" action="{{URL::to('/add-regulation')}}">
                {{ csrf_field() }}
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="">Số tiền nợ tối đa<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input type="text" id="first-name" required="required" class="form-control " name="so_tien_no_toi_da">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Số lượng nhập tối thiểu<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="first-name" required="required" class="form-control " name="so_luong_nhap_toi_thieu">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Số lượng tồn tối đa trước khi nhập<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="first-name" required="required" class="form-control "  name="so_luong_ton_toi_da_truoc_khi_nhap">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Số lượng tồn tối thiểu<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="first-name" required="required" class="form-control " name="so_luong_ton_toi_thieu">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Tỉ lệ tính đơn giá bán<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 ">
                    <input id="first-name" required="required" class="form-control "  name="ti_le_gia_ban">
                </div>
            </div>
            <div class="ln_solid"></div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <button class="btn btn-primary" type="reset">Reset</button>
                    <button type="submit" class="btn btn-success">Thêm</button>
                </div>
            </div>
        </form>
    </div>
</div>
           
     
@endsection
