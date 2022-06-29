<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();
class AuthorController extends Controller
{
    public function showAuthor()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_author = DB::table('tbl_author')->get();
        return view('management.author.show_author')->with('all_author', $all_author)->with('staff',$staff);       
    }

    public function addAuthor(Request $request)
    {
        $data = array();
        $data['author_name'] = $request->user_name;
        $data['author_story'] = $request->story;
        $data['author_email'] = $request->user_email;
        $data['author_phone'] = $request->user_phone;
        $data['author_birthday'] = $request->year;

        DB::table('tbl_author')->insert($data);
        Session::put('message', 'Thêm tác giả thành công');
        return redirect('/show-author');
    }

    public function updateAuthor(Request $request, $id)
    {
        $author = array();
        $author['author_name'] = $request->user_name;
        $author['author_story'] = $request->story;
        $author['author_email'] = $request->user_email;
        $author['author_phone'] = $request->user_phone;
        $author['author_birthday'] = $request->year;

        DB::table('tbl_author')->where('author_id', $id)->update($author);
        
        Session::put('message', 'Cập nhật tác giả thành công');
        return redirect('/show-author');       
    }

    public function deleteAuthor($id)
    {
        DB::table('tbl_detail_author')->where('author_id',$id)->delete();
        DB::table('tbl_author')->where('author_id', $id)->delete();
        Session::put('message', 'Xóa tác giả thành công');
        return redirect('/show-author');
    }
}
