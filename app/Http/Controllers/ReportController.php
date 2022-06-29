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

class ReportController extends Controller
{
    public function showReportStock(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        return view('report.report_stock')->with('staff',$staff);
    }

    public function showReportDebt(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        return view('report.report_debt')->with('staff',$staff);
    }
    //Report Stock
    public function viewReportStock(Request $request){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $month  = $request->month;
        $year = $request->year;
        $all_stock = DB::table('tbl_report_stock')->where('month',$month)->where('year',$year)->get();
        $all_book = DB::table('tbl_book')->get();
        $output = '';
        $output.='
        <h4 style="color: #0085ff;
        padding-left: 20px;
        padding-top: 20px;">Báo cáo tồn kho tháng '.$month.' năm '.$year.'</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên sách</th>
                                <th>Năm PH</th>
                                <th>Tồn đầu</th>
                                <th>Phát sinh</th>
                                <th>Tồn cuối</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Tên sách</th>
                                <th>Năm PH</th>
                                <th>Tồn đầu</th>
                                <th>Phát sinh</th>
                                <th>Tồn cuối</th>     
                            </tr>
                        </tfoot>
                        <tbody>
                        ';
                        $i = 0;
                        foreach($all_stock as $stock){
                            $i++;
                            $output.='<tr> <td>'.$i.'</td>';
                            foreach($all_book as $book){
                                if($book->book_id == $stock->book_id){
                                    $output.= '<td>'.$book->book_name.'</td>
                                    <td>'.$book->year_publish.'</td>';
                                }
                            }
                            $output.='
                                <td>'.$stock->first_stock.'</td>
                                <td>'.$stock->incurred.'</td>
                                <td>'.$stock->final_stock.'</td> </tr>
                            ';
                        }                         
                        $output.=' </tbody>
                    </table>
                </div>
            </div>
        ';
        return $output;
    }

    public function printReportStock($month,$year){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_report_stock_convert($month,$year));
        return $pdf->stream();
    }
    public function print_report_stock_convert($month,$year){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_stock = DB::table('tbl_report_stock')->where('month',$month)->where('year',$year)->get();
        $all_book = DB::table('tbl_book')->get();
        $output = '';
        $output = '
        <style>
            table {
                border: 1px solid #ccc;
                border-collapse: collapse;
                margin: 0;
                padding: 0;
                width: 100%;
                table-layout: fixed;
            }
            
            table caption {
                font-size: 1.5em;
                margin: .5em 0 .75em;
            }
            
            table tr {
                background-color: #f8f8f8;
                border: 1px solid #ddd;
                padding: .35em;
            }
            
            table th,
            table td {
                padding: .625em;
                text-align: center;
            }
            
            table th {
                font-size: .85em;
                letter-spacing: .1em;
                text-transform: uppercase;
            }
            
            body {
                font-family: DejaVu Sans;
                line-height: 1;
            }
        </style>
        <table>
            <caption>BÁO CÁO TỒN KHO THÁNG '.$month.' NĂM '.$year.'</caption>
            <thead>
            <tr>
                <th>STT</th>
                <th>Tên sách</th>
                <th>Năm phát hành</th>
                <th>Tồn đầu</th>
                <th>Phát sinh</th>
                <th>Tồn cuối</th>                
            </tr>
            </thead>
            <tbody>';
            $i = 0;
            foreach($all_stock as $stock){
                $i++;
                $output.='<tr> <td>'.$i.'</td>';
                foreach($all_book as $book){
                    if($book->book_id == $stock->book_id){
                        $output.= '<td>'.$book->book_name.'</td>
                        <td>'.$book->year_publish.'</td>';
                    }
                }
                $output.='
                    <td>'.$stock->first_stock.'</td>
                    <td>'.$stock->incurred.'</td>
                    <td>'.$stock->final_stock.'</td> </tr>
                ';
            }                                  
           $output.='</tbody>
                </table>'; 
        return $output;   
    }
    //Report Debt
    public function viewReportDebt(Request $request){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $month  = $request->month;
        $year = $request->year;
        $all_debt = DB::table('tbl_report_debt')->where('month',$month)->where('year',$year)->get();
        $all_client = DB::table('tbl_client')->get();
        $output = '';
        $output.='
        <h4 style="color: #0085ff;
        padding-left: 20px;
        padding-top: 20px;">Báo cáo công nợ tháng '.$month.' năm '.$year.'</h4>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Khách hàng</th>
                                <th>Nợ đầu</th>
                                <th>Phát sinh</th>
                                <th>Nợ cuối</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Khách hàng</th>
                                <th>Nợ đầu</th>
                                <th>Phát sinh</th>
                                <th>Nợ cuối</th>  
                            </tr>
                        </tfoot>
                        <tbody>
                        ';
                        $i = 0;
                        foreach($all_debt as $debt){
                            $i++;
                            $output.='<tr> <td>'.$i.'</td>';
                            foreach($all_client as $client){
                                if($client->client_id == $debt->client_id){
                                    $output.= '<td>'.$client->client_name.'</td>';
                                }
                            }
                            $output.='
                                <td>'.number_format($debt->first_debt).'đ</td>
                                <td>'.number_format($debt->incurred).'đ</td>
                                <td>'.number_format($debt->final_debt).'đ</td> </tr>
                            ';
                        }                         
                        $output.=' </tbody>
                    </table>
                </div>
            </div>
        ';
        return $output;
    }
    public function printReportDebt($month,$year){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_report_debt_convert($month,$year));
        return $pdf->stream();
    }
    public function print_report_debt_convert($month,$year){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_debt = DB::table('tbl_report_debt')->where('month',$month)->where('year',$year)->get();
        $all_client = DB::table('tbl_client')->get();
        $output = '';
        $output = '
        <style>
            table {
                border: 1px solid #ccc;
                border-collapse: collapse;
                margin: 0;
                padding: 0;
                width: 100%;
                table-layout: fixed;
            }
            
            table caption {
                font-size: 1.5em;
                margin: .5em 0 .75em;
            }
            
            table tr {
                background-color: #f8f8f8;
                border: 1px solid #ddd;
                padding: .35em;
            }
            
            table th,
            table td {
                padding: .625em;
                text-align: center;
            }
            
            table th {
                font-size: .85em;
                letter-spacing: .1em;
                text-transform: uppercase;
            }
            
            body {
                font-family: DejaVu Sans;
                line-height: 1;
            }
        </style>
        <table>
            <caption>BÁO CÁO CÔNG NỢ THÁNG '.$month.' NĂM '.$year.'</caption>
            <thead>
            <tr>
                <th>STT</th>
                <th>Khách hàng</th>
                <th>Nợ đầu</th>
                <th>Phát sinh</th>
                <th>Nợ cuối</th>            
            </tr>
            </thead>
            <tbody>';
            $i = 0;
            foreach($all_debt as $debt){
                $i++;
                $output.='<tr> <td>'.$i.'</td>';
                foreach($all_client as $client){
                    if($client->client_id == $debt->client_id){
                        $output.= '<td>'.$client->client_name.'</td>';
                    }
                }
                $output.='
                    <td>'.number_format($debt->first_debt).'đ</td>
                    <td>'.number_format($debt->incurred).'đ</td>
                    <td>'.number_format($debt->final_debt).'đ</td> </tr>
                ';
            }                                              
           $output.='</tbody>
                </table>'; 
        return $output;   
    }
}
