<?php

namespace App\Http\Controllers;

use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Cart;
use Illuminate\Pagination\Paginator;
use Storage;
use Carbon\Carbon;
session_start();

class BookEntryMoneyController extends Controller
{
    public function showBookEntryMoney()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_entry_book = DB::table('tbl_entry_money')->orderBy('entry_money_id','DESC')->get();
        return view('management.bookentrymoney.book_entry_money')->with('all_entry_money', $all_entry_book)->with('staff',$staff);       
    }

    public function showAllBook()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $regulation = DB::table('tbl_regulation')->first();
        $all_title = DB::table('tbl_title')->get();
        $all_book = DB::table('tbl_book')->join('tbl_title', 'tbl_title.title_id', '=', 'tbl_book.title_id')->get();
        return view('management.bookentrymoney.show_all_book')->with(compact('all_book', 'all_title','regulation','staff'));       
    }

    public function showDetailBookEntryMoney($id)
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_detail_entry = DB::table('tbl_detail_entry_money')->where('entry_money_id', $id)->get();
        $entry_book = DB::table('tbl_entry_money')->where('entry_money_id', $id)->first();
        return view('management.bookentrymoney.show_detail_book_entry')->with('all_detail_entry', $all_detail_entry)
                            ->with('entry_book', $entry_book)->with('staff',$staff);
    }

    public function deleteBookEntryMoney($id)
    {
        $detail_entry = DB::table('tbl_detail_entry_money')->where('entry_money_id', $id)->get();
        foreach ($detail_entry as $key => $ord) {
            $productData = array();
            $product = DB::table('tbl_book')->where('book_id', $ord->book_id)->first();

            $productData['stock'] = $product->stock - $ord->quantity;

            DB::table('tbl_book')->where('book_id', $ord->book_id)->update($productData);
            DB::table('tbl_detail_entry_money')->where('detail_entry_money_id', $ord->detail_entry_money_id)->delete();
        }
        $delete_order = DB::table('tbl_entry_money')->where('entry_money_id', $id)->delete();
        Session::put('message', 'Xóa phiếu nhập sách thành công thành công');
        return redirect('/show-book-entry-money');
    }
    public function getInforBook($book_id){ 
        $book = DB::table('tbl_book')->join('tbl_title', 'tbl_title.title_id', '=', 'tbl_book.title_id')->where('book_id', $book_id)->first();
        $title = DB::table('tbl_title')
        ->join('tbl_category', 'tbl_category.category_id', '=', 'tbl_title.category_id')
        ->join('tbl_publisher', 'tbl_publisher.publisher_id', '=', 'tbl_title.publisher_id')
        ->where('title_id', $book->title_id)->first();
        $author = DB::table('tbl_detail_author')->join('tbl_author', 'tbl_author.author_id', '=', 'tbl_detail_author.author_id')
        ->where('title_id', $book->title_id)->get();

        $author_names = array();
        foreach($author as $name){
            array_push($author_names, $name->author_name);
        }

        return response()->json([
            'authors' => $author_names,
            'category' => $title->category_name,
            'publisher' => $title->publisher_name,
            'book' => $book->book_name
        ]);
    }

    
    public function saveEntryMoney(Request $request)
    {
        //insert entry money
        $entryMoney = array();
        $entryMoney['staff_id'] = Session::get('id');
        $entryMoney['date'] = Carbon::now('Asia/Ho_Chi_Minh');
        $entryMoney['total'] = $request->cart_total;
        $entry_id = DB::table('tbl_entry_money')->insertGetId($entryMoney);
        // insert  detail entry money
        $content = Cart::content();
        $regulation = DB::table('tbl_regulation')->first();
        foreach ($content as $v_content) {
            $detaildData = array();
            $detaildData['entry_money_id'] = $entry_id;
            $detaildData['book_id'] = $v_content->id;
            $detaildData['book_name'] = $v_content->name;
            $detaildData['price'] = $v_content->price;
            $detaildData['quantity'] = $v_content->qty;
            $detaildData['total'] = $v_content->price * $v_content->qty;
            DB::table('tbl_detail_entry_money')->insert($detaildData);

            $product = DB::table('tbl_book')->where('book_id', $v_content->id)->first();
            $productData = array();
            $productData['stock'] = $product->stock + $v_content->qty;
            $productData['price'] = $v_content->price * $regulation->TiLeTinhDonGiaBan;
            DB::table('tbl_book')->where('book_id', $v_content->id)->update($productData);
        }
        $entry_book = DB::table('tbl_entry_money')->where('entry_money_id', $entry_id)->first();
        $all_detail_entry = DB::table('tbl_detail_entry_money')->where('entry_money_id', $entry_id)->get();
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        Cart::destroy();
        return view('management.bookentrymoney.show_detail_book_entry')->with('entry_book', $entry_book)->with('all_detail_entry', $all_detail_entry)->with('staff',$staff);
    }
}
