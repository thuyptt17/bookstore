<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class TitleController extends Controller
{
    public function showTitle()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_title = DB::table('tbl_title')->join('tbl_category', 'tbl_category.category_id', '=', 'tbl_title.category_id')
        ->join('tbl_publisher', 'tbl_publisher.publisher_id', '=', 'tbl_title.publisher_id')->get();
        $all_detail_author = DB::table('tbl_detail_author')->join('tbl_author', 'tbl_author.author_id', '=', 'tbl_detail_author.author_id')->get();
        $all_author = DB::table('tbl_author')->get();
        $all_publisher = DB::table('tbl_publisher')->get();
        $all_category = DB::table('tbl_category')->get();
        return view('management.title.show_title')->with(compact('all_title', 'all_author', 'all_category','all_publisher','all_detail_author','staff'));  
    }

    public function addTitle(Request $request)
    {
        $data = array();
        $data['title_name'] = $request->bookname;
        $data['category_id'] = $request->type;
        $data['publisher_id'] = $request->publisher; 
        DB::table('tbl_title')->insert($data);
        $data1 = DB::table('tbl_title')->latest('title_id')->first();
        $id = $data1->title_id;
        $arr = $request->author;
        foreach($arr as $value){
            $data2 = array();
            $data2['title_id'] = $id;
            $data2['author_id'] = $value;
            DB::table('tbl_detail_author')->insert($data2);
        }
        Session::put('message', 'Thêm đầu sách thành công');
        return redirect('/show-title');
    }

    public function updateTitle(Request $request, $id)
    {
        $data = array();
        $data['title_name'] = $request->bookname;
        $data['category_id'] = $request->type;
        $data['publisher_id'] = $request->publisher;
        DB::table('tbl_title')->where('title_id', $id)->update($data);
        DB::table('tbl_detail_author')->where('title_id', $id)->delete();
        $arr = $request->author;
        foreach($arr as $value){
            $data2 = array();
            $data2['title_id'] = $id;
            $data2['author_id'] = $value;
            
            DB::table('tbl_detail_author')->insert($data2);
        }
        Session::put('message', 'Cập nhật đầu sách thành công');
        return redirect('/show-title');  
    }

    public function deleteTitle($id)
    {
        $book =  DB::table('tbl_book')->where('title_id', $id)->first();
        if($book->stock != 0){
            Session::put('message', 'Không thể xóa sách vì còn sách còn số lượng tồn.');
        } else {
            DB::table('tbl_book')->where('title_id', $id)->delete();
            DB::table('tbl_detail_author')->where('title_id', $id)->delete();
            DB::table('tbl_title')->where('title_id', $id)->delete();
            Session::put('message', 'Xóa đầu sách thành công');
        }
        return redirect('/show-title');
    }

}
