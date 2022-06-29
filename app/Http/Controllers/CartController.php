<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Storage;
use Cart;
session_start();

class CartController extends Controller
{
    public function showCart(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $regulation = DB::table('tbl_regulation')->first();
        return view('management.bookentrymoney.add_book_entry_money')->with('regulation', $regulation)->with('staff',$staff);
    }

    public function showBillCart(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_book = DB::table('tbl_book')->get();
        $all_client = DB::table('tbl_client')->get();
        $regulation = DB::table('tbl_regulation')->first();
        return view('management.bill.add_bill')->with('regulation', $regulation)->with('all_client', $all_client)->with('staff',$staff)
        ->with('all_book',$all_book);
    }


    public function addProductCart(Request $request){
        $data['id'] = $request->product_id_hidden;
        $data['qty'] = $request->qty_cart;
        $data['name'] = $request->product_cart_name;
        $data['price'] = $request->product_cart_price;
        $data['weight'] = 1;
        $regulation = DB::table('tbl_regulation')->first();
        $product = DB::table('tbl_book')->where('book_id', $data['id'])->first();
        if($product->stock > $regulation->SoLuongTonToiDaTruocKhiNhap){
            Session::put('message', 'Không nhập sách này vì số lượng tồn lớn hơn số lượng tồn tối đa trước khi nhập theo qui định');
        } else {
            Cart::add($data);
            Session::put('message','Thêm sách vào phiếu nhập thành công');
        }
        return redirect()->back();
    }

    public function deleteProductCart($id){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        Cart::update($id, 0);
        $regulation = DB::table('tbl_regulation')->first();
        return view('management.bookentrymoney.add_book_entry_money')->with('regulation', $regulation)->with('staff',$staff);
    }

    public function deleteBookCart($id){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        Cart::update($id, 0);
        $all_client = DB::table('tbl_client')->get();
        $regulation = DB::table('tbl_regulation')->first();
        return view('management.bill.add_bill')->with('regulation', $regulation)->with('all_client', $all_client)->with('staff',$staff);
    }

    public function updateQuantityCart(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->qty_cart;
        if ($qty >= 0) {
            Cart::update($rowId,$qty);
        }
    }

    public function updatePriceCart(Request $request){
        $rowId = $request->rowId_cart;
        $price =  $request->price;
        if ($price >= 0) {
            Cart::update($rowId, ['price' => $price]);  
        }
    }

    
    public function addBookCart(Request $request){
        $data['id'] = $request->product_id_hidden;
        $data['qty'] = $request->qty_cart;
        $data['name'] = $request->product_cart_name;
        $data['price'] = $request->product_cart_price;
        $data['weight'] = 1;
        $regulation = DB::table('tbl_regulation')->first();
        $product = DB::table('tbl_book')->where('book_id', $data['id'])->first();
        if($product->stock < $data['qty'] || ($product->stock - $data['qty']) < $regulation->SoLuongTonToiThieu){
            Session::put('message', 'Số lượng sách không đủ để bán.');
        } else {
            Cart::add($data);
            Session::put('message','Thêm sách vào hóa đơn thành công');
        }
        return redirect()->back();
    }
}
