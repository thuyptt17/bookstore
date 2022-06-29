<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();
class PublisherController extends Controller
{
    public function showPublisher()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_publisher = DB::table('tbl_publisher')->get();
        return view('management.publisher.show_publisher')->with('all_publisher',$all_publisher)->with('staff',$staff);       
    }

    public function addPublisher(Request $request)
    {
        $data = array();
        $data['publisher_name'] = $request->user_name;
        $data['publisher_address'] = $request->address;
        $data['publisher_email'] = $request->user_email;
        $data['publisher_phone'] = $request->user_phone;
        DB::table('tbl_publisher')->insert($data);
        Session::put('message', 'Thêm nhà xuất bản thành công');
        return redirect('/show-publisher');
    }

    public function updatePublisher(Request $request, $id)
    {
        $data = array();
        $data['publisher_name'] = $request->user_name;
        $data['publisher_address'] = $request->address;
        $data['publisher_email'] = $request->user_email;
        $data['publisher_phone'] = $request->user_phone;
        DB::table('tbl_publisher')->where('publisher_id', $id)->update($data);
        
        Session::put('message', 'Cập nhật nhà xuất bản thành công');
        return redirect('/show-publisher');       
    }

    public function deletePublisher($id)
    {
        DB::table('tbl_title')->where('title_id', $id)->delete();
        DB::table('tbl_publisher')->where('publisher_id', $id)->delete();
        Session::put('message', 'Xóa nhà xuất bản thành công');
        return redirect('/show-publisher');
    }
}
