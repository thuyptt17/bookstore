<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Pagination\Paginator;
use Storage;
use Carbon\Carbon;
session_start();

class EntryMoneyController extends Controller
{
    public function showEntryMoney()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_entry_money = DB::table('tbl_debt')->get();
        $all_client = DB::table('tbl_client')->where('client_debt', '>', 0)->get();
        $all_clients = DB::table('tbl_client')->get();
        return view('management.entrymoney.entry_money')->with('all_entry_money',$all_entry_money)
        ->with('all_client',$all_client)->with('staff',$staff)->with('all_clients',$all_clients);       
    }
    public function addEntryMoney(Request $request)
    {
        $data = array();
        $data['client_id'] = $request->name;
        $data['date'] = Carbon::now('Asia/Ho_Chi_Minh');
        $data['money'] = $request->money;
        DB::table('tbl_debt')->insert($data);
        $client = DB::table('tbl_client')->where('client_id',$request->name)->first();
        $dataClient = array();
        $dataClient['client_debt'] = $client->client_debt - $request->money;
        DB::table('tbl_client')->where('client_id',$request->name)->update($dataClient);
        Session::put('message', 'Thêm phiếu thu tiền  thành công');
        return redirect('/show-entry-money');
    }

    public function deleteEntryMoney($id)
    {
        $entry_money = DB::table('tbl_debt')->where('debt_id',$id)->first();
        $client = DB::table('tbl_client')->where('client_id',$entry_money->client_id)->first();
        $dataClient = array();
        $dataClient['client_debt'] = $client->client_debt + $entry_money->money;
        DB::table('tbl_client')->where('client_id',$entry_money->client_id)->update($dataClient);
        DB::table('tbl_debt')->where('debt_id', $id)->delete();
        Session::put('message', 'Xóa phiếu thu tiền thành công');
        return redirect('/show-entry-money');
    }

}
