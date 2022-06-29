<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();
class BookController extends Controller
{
    public function showBook()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_book = DB::table('tbl_book')->join('tbl_title', 'tbl_title.title_id', '=', 'tbl_book.title_id')->get();
        $all_title = DB::table('tbl_title')->get();
        return view('management.book.show_book')->with(compact('all_book', 'all_title','staff'));  
    }
  
    public function addBook(Request $request)
    {
        $data = array();
        $data['book_name'] = $request->bookname;
        $data['title_id'] = $request->title;
        $path = 'resources/img';
        $image_name = $request->file('img')->getClientOriginalName();
        $image_name = current(explode('.', $image_name));
        $new_image_name = $image_name . rand(0, 99) . '.' .$request->file('img')->getClientOriginalExtension();
        $request->file('img')->move($path, $new_image_name);
        $data['image'] =  $new_image_name;
        $data['year_publish'] = $request->year;
        $data['price'] = 0;
        $data['stock'] = 0;
        $data['edition'] = $request->edition;
        DB::table('tbl_book')->insert($data);
        Session::put('message', 'Thêm sách thành công');
        return redirect('/show-book');
    }

    public function updateBook(Request $request, $id)
    {
        $data = array();
        $data['book_name'] = $request->bookname;
        $data['title_id'] = $request->title;
        $image = $request->file('img');
        if ($image != NULL) {
            $path = 'resources/img';
            $image_name = $image->getClientOriginalName();
            $image_name = current(explode('.', $image_name));
            $new_image_name = $image_name . rand(0, 99) . '.' .$image->getClientOriginalExtension();
            $image->move($path, $new_image_name);
            $data['image'] =  $new_image_name;   
        }
        $data['year_publish'] = $request->year;
        $data['price'] = $request->price;
        $data['stock'] = $request->stock;
        $data['edition'] = $request->edition;
        DB::table('tbl_book')->where('book_id', $id)->update($data);
        Session::put('message', 'Cập nhật sách thành công');
        return redirect('/show-book');  
    }

    public function deleteBook($id)
    { 
        $book = DB::table('tbl_book')->where('book_id', $id)->first();
        if($book->stock != 0){
            Session::put('message', 'Không thể xóa sách vì còn sách còn số lượng tồn.');
        } else {  
            DB::table('tbl_book')->where('book_id', $id)->delete();
            Session::put('message', 'Xóa sách thành công');
        }
        return redirect('/show-book');

    }

    public function showSearchBook(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        return view('management.search.search_book')->with(compact('staff')); 
    }

    public function searchBook(Request $request){
        $timkiem = $request->tukhoa;
        $all_book = DB::table('tbl_book')->join('tbl_title', 'tbl_title.title_id', '=', 'tbl_book.title_id')->where('book_name', 'like', '%' . $timkiem . '%')->get();
        $output = '';
        $output.='
        <h4 style="color: #0085ff;
        padding-left: 20px;
        padding-top: 20px;">Danh sách các sách tìm kiếm theo '.$timkiem.'</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sách</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>Giá bán</th>
                                <th>SL Tồn</th>
                                <th>Lần xuất bản</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Tên sách</th>
                                <th>Đầu sách</th>
                                <th>Năm PH</th>
                                <th>Giá bán</th>
                                <th>SL Tồn</th>
                                <th>Lần xuất bản</th> 
                            </tr>
                        </tfoot>
                        <tbody>
                        ';
                        $i = 0;
                        foreach($all_book as $book){
                            $i++;
                            $output.='<tr> <td>'.$i.'</td>';
                            $output.='
                            <td>'.$book->book_name.'</td>
                            <td>'.$book->title_name.'</td>
                            <td>'.$book->year_publish.'</td>
                            <td>'.number_format($book->price).'đ</td>
                            <td>'.$book->stock.'</td>
                            <td>'.$book->edition.'</td> </tr>
                            ';
                        }                         
                        $output.=' </tbody>
                    </table>
                </div>
            </div>
        ';
        return $output;
    }
}
