<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class DiscountController extends Controller
{
    public function showDiscount()
    {
        $all_discount = DB::table('tbl_discount')->get();
        return view('management.discount.show_discount')->with('all_discount', $all_discount);       
    }

    public function addDiscount(Request $request)
    {
        $data = array();
        $data['discount_code'] = $request->code;
        $data['discount_desc'] = $request->describe;
        $data['discount_percent'] = $request->percent;
        $data['discount_start'] = $request->startdate;
        $data['discount_end'] = $request->enddate;
        DB::table('tbl_discount')->insert($data);
        Session::put('message', 'Thêm khuyến mãi thành công');
        return redirect('/show-discount');
    }

    
    public function updateDiscount(Request $request, $id)
    {
        $data = array();
        $data['discount_code'] = $request->code;
        $data['discount_desc'] = $request->describe;
        $data['discount_percent'] = $request->percent;
        $data['discount_start'] = $request->startdate;
        $data['discount_end'] = $request->enddate;

        DB::table('tbl_discount')->where('discount_id', $id)->update($data);
        Session::put('message', 'Cập nhật khuyến mãi thành công');
        return redirect('/show-discount');       
    }

    
    public function deleteDiscount($id)
    {
        DB::table('tbl_discount')->where('discount_id', $id)->delete();
        Session::put('message', 'Xóa khuyến mãi thành công');
        return redirect('/show-discount');
    }
}
