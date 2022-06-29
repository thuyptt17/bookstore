<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class RegulationController extends Controller
{
    public function showRegulation()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $regulation = DB::table('tbl_regulation')->get();
        return view('regulation.show_regulation')->with('regulation', $regulation)->with('staff',$staff);       
    }

    
    public function addRegulation(Request $request)
    {
        $data = array();
        $data['SoTienNoToiDa'] = $request->so_tien_no_toi_da;
        $data['SoLuongNhapToiThieu'] = $request->so_luong_nhap_toi_thieu;
        $data['SoLuongTonToiDaTruocKhiNhap'] = $request->so_luong_ton_toi_da_truoc_khi_nhap;
        $data['SoLuongTonToiThieu'] = $request->so_luong_ton_toi_thieu;
        $data['TiLeTinhDonGiaBan'] = $request->ti_le_gia_ban;

        DB::table('tbl_regulation')->insert($data);
        Session::put('message', 'Thêm qui định thành công');
        return redirect('/show-regulation');
    }

    public function updateRegulation(Request $request, $id)
    {
        $data = array();
        $data['SoTienNoToiDa'] = $request->so_tien_no_toi_da;
        $data['SoLuongNhapToiThieu'] = $request->so_luong_nhap_toi_thieu;
        $data['SoLuongTonToiDaTruocKhiNhap'] = $request->so_luong_ton_toi_da_truoc_khi_nhap;
        $data['SoLuongTonToiThieu'] = $request->so_luong_ton_toi_thieu;
        $data['TiLeTinhDonGiaBan'] = $request->ti_le_gia_ban;

        DB::table('tbl_regulation')->where('id', $id)->update($data);
        Session::put('message', 'Cập nhật qui định thành công');
        return redirect('/show-regulation');       
    }

}
