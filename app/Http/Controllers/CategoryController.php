<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
session_start();
class CategoryController extends Controller
{
    public function showCategory()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_category = DB::table('tbl_category')->get();
        return view('management.category.show_category')->with('all_category',$all_category)->with('staff',$staff);       
    }

    public function addCategory(Request $request)
    {
        $data = array();
        $data['category_name'] = $request->user_name;
        $data['category_desc'] = $request->describe;
        DB::table('tbl_category')->insert($data);
        Session::put('message', 'Thêm thể loại thành công');
        return redirect('/show-category');
    }

    public function updateCategory(Request $request, $id)
    {
        $data = array();
        $data['category_name'] = $request->user_name;
        $data['category_desc'] = $request->describe;
        DB::table('tbl_category')->where('category_id', $id)->update($data);
        
        Session::put('message', 'Cập nhật thể loại thành công');
        return redirect('/show-category');       
    }

    public function deleteCategory($id)
    {
        DB::table('tbl_title')->where('title_id', $id)->delete();
        DB::table('tbl_category')->where('category_id', $id)->delete();
        Session::put('message', 'Xóa thể loại thành công');
        return redirect('/show-category');
    }

}
