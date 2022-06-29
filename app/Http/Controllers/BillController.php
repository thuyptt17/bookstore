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
use PDF;
session_start();

class BillController extends Controller
{
    public function printBill($id){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($id));
        return $pdf->stream();
    }
    public function print_order_convert($id){
        $bill = DB::table('tbl_bill')->where('bill_id',$id)->first();
        $client = DB::table('tbl_client')->where('client_id',$bill->client_id)->first();
        $all_detail_bill = DB::table('tbl_detail_bill')->where('bill_id',$bill->bill_id)->get();
        $all_book = DB::table('tbl_book')->get();
        $quantity = 0;
        foreach($all_detail_bill as $key1 => $ord1){
            $quantity += $ord1->quantity;
        }
        $staff = DB::table('tbl_staff')->where('staff_id',$bill->staff_id)->first();
        $output = '';
        $output.='
        <style>
        body{margin-top:20px;
            background-color: #f7f7ff;
            font-family: DejaVu Sans;
            }
            #invoice {
                padding: 0px;
            }
            
            .invoice {
                position: relative;
                background-color: #FFF;
                min-height: 680px;
                padding: 15px
            }
            
            .invoice header {
                padding: 10px 0;
                margin-bottom: 20px;
                border-bottom: 1px solid #0d6efd
            }
            
            .invoice .company-details {
                text-align: right
            }
            
            .invoice .company-details .name {
                margin-top: 0;
                margin-bottom: 0
            }
            
            .invoice .contacts {
                margin-bottom: 20px
            }
            
            .invoice .invoice-to {
                text-align: left
            }
            
            .invoice .invoice-to .to {
                margin-top: 0;
                margin-bottom: 0
            }
            
            .invoice .invoice-details {
                text-align: right
            }
            
            .invoice .invoice-details .invoice-id {
                margin-top: 0;
                color: #0d6efd
            }
            
            .invoice main {
                padding-bottom: 50px
            }
            
            .invoice main .thanks {
                margin-top: -100px;
                font-size: 2em;
                margin-bottom: 50px
            }
            
            .invoice main .notices {
                padding-left: 6px;
                border-left: 6px solid #0d6efd;
                background: #e7f2ff;
                padding: 10px;
            }
            
            .invoice main .notices .notice {
                font-size: 1.2em
            }
            
            .invoice table {
                width: 100%;
                border-collapse: collapse;
                border-spacing: 0;
                margin-bottom: 20px
            }
            
            .invoice table td,
            .invoice table th {
                padding: 15px;
                background: #eee;
                border-bottom: 1px solid #fff
            }
            
            .invoice table th {
                white-space: nowrap;
                font-weight: 400;
                font-size: 16px
            }
            
            .invoice table td h3 {
                margin: 0;
                font-weight: 400;
                color: #0d6efd;
                font-size: 1.2em
            }
            
            .invoice table .qty,
            .invoice table .total,
            .invoice table .unit {
                text-align: right;
                font-size: 1.2em
            }
            
            .invoice table .no {
                color: #fff;
                font-size: 1.6em;
                background: #0d6efd
            }
            
            .invoice table .unit {
                background: #ddd
            }
            
            .invoice table .total {
                background: #0d6efd;
                color: #fff
            }
            
            .invoice table tbody tr:last-child td {
                border: none
            }
            
            .invoice table tfoot td {
                background: 0 0;
                border-bottom: none;
                white-space: nowrap;
                text-align: right;
                padding: 10px 20px;
                font-size: 1.2em;
                border-top: 1px solid #aaa
            }
            
            .invoice table tfoot tr:first-child td {
                border-top: none
            }
            .card {
                position: relative;
                display: flex;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-color: #fff;
                background-clip: border-box;
                border: 0px solid rgba(0, 0, 0, 0);
                border-radius: .25rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 2px 6px 0 rgb(218 218 253 / 65%), 0 2px 6px 0 rgb(206 206 238 / 54%);
            }
            
            .invoice table tfoot tr:last-child td {
                color: #0d6efd;
                font-size: 1.4em;
                border-top: 1px solid #0d6efd
            }
            
            .invoice table tfoot tr td:first-child {
                border: none
            }
            
            .invoice footer {
                width: 100%;
                text-align: center;
                color: #777;
                border-top: 1px solid #aaa;
                padding: 8px 0
            }
            
            @media print {
                .invoice {
                    font-size: 11px !important;
                    overflow: hidden !important
                }
                .invoice footer {
                    position: absolute;
                    bottom: 10px;
                    page-break-after: always
                }
                .invoice>div:last-child {
                    page-break-before: always
                }
            }
            
            .invoice main .notices {
                padding-left: 6px;
                border-left: 6px solid #0d6efd;
                background: #e7f2ff;
                padding: 10px;
            }
        </style>
        <div class="container">
    <div class="card">
        <div class="card-body">
            <div id="invoice">
                
                <div class="invoice overflow-auto">
                    <div style="min-width: 600px">
                        <header>
                            <div class="row">
                                <div class="col company-details">
                                    <h2 class="name">
                                        <a target="_blank" href="javascript:;">
									Arboshiki
									</a>
                                    </h2>
                                    <div>Khu phố 6, phường Linh Trung, TP Thủ Đức</div>
                                    <div>(123) 456-789</div>
                                    <div>company@example.com</div>
                                </div>
                            </div>
                        </header>
                        <main>
                            <div class="row contacts">
                                <div class="col invoice-to">
                                    <div class="text-gray-light">Khách hàng:</div>
                                    <h2 class="to">'.$client->client_name.'</h2>
                                    <div class="address">'.$client->client_address.'</div>
                                    <div class="phone">'.$client->client_phone.'</div>
                                    <div class="email">'.$client->client_email.'</div>
                                </div>
                                <div class="col invoice-details">
                                    <h1 class="invoice-id">HÓA ĐƠN: HĐ0'.$bill->bill_id.'</h1>
                                    <div class="date">Ngày lập: '.$bill->bill_date.'</div>
                                    <div class="date">Ngày thanh toán: '.$bill->bill_date.'</div>
                                </div>
                            </div>
                            <table>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-left">SẢN PHẨM</th>
                                        <th class="text-right">GIÁ BÁN</th>
                                        <th class="text-right">SỐ LƯỢNG</th>
                                        <th class="text-right">TỔNG CỘNG</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                $i = 0;
                                foreach($all_detail_bill as $item){
                                    $i = $i + 1;
                                    $output.='<tr>
                                        <td class="no">'.$i.'</td>
                                        <td class="text-left">
                                            ';
                                    foreach($all_book as $book){
                                        if($book->book_id == $item->book_id){
										 $output.=''.$book->book_name.'
                                         ';
                                        }
                                    }
									$output.='</td>
                                        <td class="unit">'.number_format($item->price).' đ</td>
                                        <td class="qty">'.$item->quantity.'</td>
                                        <td class="total">'.number_format($item->total).' đ</td>
                                    </tr>';
                                } 
                                $output.='                      
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">Thành tiền</td>
                                        <td>'.number_format($bill->bill_total).' đ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">Tiền khách trả</td>
                                        <td>'.number_format($bill->bill_pay).' đ</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td colspan="2">Tiền nợ</td>
                                        <td>'.number_format($bill->bill_total - $bill->bill_pay).' đ</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="thanks">Thank you!</div>
                        </main>
                        <footer>Invoice was created on a computer and is valid without the signature and seal.</footer>
                    </div>
                    <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    </div>
        ';
        return $output;
    }

    public function showBill()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_bill = DB::table('tbl_bill')->get();
        $all_client = DB::table('tbl_client')->get();
        $all_staff = DB::table('tbl_staff')->get();
        return view('management.bill.show_bill')->with('all_bill',$all_bill)->with('all_client',$all_client)
        ->with('all_staff',$all_staff)->with('staff',$staff);       
    }

    public function showAllBook()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $regulation = DB::table('tbl_regulation')->first();
        $all_title = DB::table('tbl_title')->get();
        $all_book = DB::table('tbl_book')->join('tbl_title', 'tbl_title.title_id', '=', 'tbl_book.title_id')->get();
        return view('management.bill.show_book_bill')->with(compact('all_book', 'all_title','regulation','staff'));       
    }

    public function saveBill(Request $request){
         //insert bill
         $bill = array();
         $bill['staff_id'] = Session::get('id');
         $bill['bill_date'] = Carbon::now('Asia/Ho_Chi_Minh');
         $bill['bill_total'] = $request->cart_total;
         $bill['client_id'] = $request->client;
         $bill['bill_pay'] = $request->payment;
         $bill_id = DB::table('tbl_bill')->insertGetId($bill);
         // insert  detail entry money
         $content = Cart::content();
         $regulation = DB::table('tbl_regulation')->first();
         foreach ($content as $v_content) {
             $detaildData = array();
             $detaildData['bill_id'] = $bill_id;
             $detaildData['book_id'] = $v_content->id;
             $detaildData['price'] = $v_content->price;
             $detaildData['quantity'] = $v_content->qty;
             $detaildData['total'] = $v_content->price * $v_content->qty;
             DB::table('tbl_detail_bill')->insert($detaildData);
 
             $product = DB::table('tbl_book')->where('book_id', $v_content->id)->first();
             $productData = array();
             $productData['stock'] = $product->stock - $v_content->qty;
             DB::table('tbl_book')->where('book_id', $v_content->id)->update($productData);
         }
        $client = DB::table('tbl_client')->where('client_id',$request->client)->first();
        $data = array();
        $data['client_debt'] = $client->client_debt + $request->still_total;
        DB::table('tbl_client')->where('client_id', $request->client)->update($data);
        $all_detail_bill = DB::table('tbl_detail_bill')->where('bill_id',$bill_id)->get();
        $bill = DB::table('tbl_bill')->where('bill_id',$bill_id)->first();
        $client = DB::table('tbl_client')->where('client_id',$bill->client_id)->first();
        $all_book = DB::table('tbl_book')->get();
        Cart::destroy();
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        return view('management.bill.show_detail_bill')->with('all_detail_bill',$all_detail_bill)
        ->with('bill',$bill)->with('client',$client)->with('all_book',$all_book)->with('staff',$staff);
    }
    public function showDetailBill($id)
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_detail_bill = DB::table('tbl_detail_bill')->where('bill_id',$id)->get();
        $bill = DB::table('tbl_bill')->where('bill_id',$id)->first();
        $client = DB::table('tbl_client')->where('client_id',$bill->client_id)->first();
        $all_book = DB::table('tbl_book')->get();
        return view('management.bill.show_detail_bill')->with('all_detail_bill',$all_detail_bill)
        ->with('bill',$bill)->with('client',$client)->with('all_book',$all_book)->with('staff',$staff);       
    }

    public function deleteBill($id)
    {
        $detail_bill = DB::table('tbl_detail_bill')->where('bill_id', $id)->get();
        foreach ($detail_bill as $key => $ord) {
            $productData = array();
            $product = DB::table('tbl_book')->where('book_id', $ord->book_id)->first();

            $productData['stock'] = $product->stock + $ord->quantity;

            DB::table('tbl_book')->where('book_id', $ord->book_id)->update($productData);
            DB::table('tbl_detail_bill')->where('detail_bill_id', $ord->detail_bill_id)->delete();
        }
        $bill = DB::table('tbl_bill')->where('bill_id', $id)->first();
        $client = DB::table('tbl_client')->where('client_id', $bill->client_id)->first();
        $data = array();
        $data['client_debt'] = $client->client_debt - ($bill->bill_total - $bill->bill_pay);
        DB::table('tbl_client')->where('client_id', $bill->client_id)->update($data);
        $delete_bill = DB::table('tbl_bill')->where('bill_id', $id)->delete();
        Session::put('message', 'Xóa hóa đơn thành công thành công');
        return redirect('/show-bill');
    }
}
