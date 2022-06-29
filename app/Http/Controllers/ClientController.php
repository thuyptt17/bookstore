<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();
class ClientController extends Controller
{
    public function showClient()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_client = DB::table('tbl_client')->get();
        return view('management.client.show_client')->with('all_client',$all_client)->with('staff',$staff);       
    }

    public function addClient(Request $request)
    {
        $data = array();
        $data['client_name'] = $request->user_name;
        $data['client_phone'] = $request->user_phone;
        $data['client_email'] = $request->user_email;
        $data['client_address'] = $request->address;
        $data['client_birthday'] = $request->birthday;
        $data['client_type'] = $request->type;
        $data['client_debt'] = 0;
        DB::table('tbl_client')->insert($data);
        Session::put('message', 'Thêm khách hàng thành công');
        return redirect('/show-client');
    }

    public function updateClient(Request $request, $id)
    {
        $author = array();
        $data['client_name'] = $request->user_name;
        $data['client_phone'] = $request->user_phone;
        $data['client_email'] = $request->user_email;
        $data['client_address'] = $request->address;
        $data['client_birthday'] = $request->birthday;
        $data['client_type'] = $request->type;
        $data['client_debt'] = 0;
        DB::table('tbl_client')->where('client_id', $id)->update($data);
        Session::put('message', 'Cập nhật khách hàng thành công');
        return redirect('/show-client');       
    }

    public function deleteClient($id)
    {
        $client = DB::table('tbl_client')->where('client_id', $id)->first();
        if($client->client_debt == 0){
            DB::table('tbl_client')->where('client_id', $id)->delete();
            Session::put('message', 'Xóa khách hàng thành công');
           
        } else {
            Session::put('message', 'Không thể xóa khách hàng vì khách còn nợ');
        }
        return redirect('/show-client');
    }
}
