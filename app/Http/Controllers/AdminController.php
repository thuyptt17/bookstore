<?php

namespace App\Http\Controllers;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

session_start();

class AdminController extends Controller
{
    public function showLogin()
    {
        return view('login');       
    }

    public function logOut(){
        return view('login');
    }
    
    public function showDashBoard(){
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        return view('admin_dashboard')->with('staff',$staff);
    }
    public function checkLogin(Request $request)
    {
        $email = $request->email;
        $pass = md5($request->password);
        $result = DB::table('tbl_staff')->where('staff_email', $email)->where('staff_password', $pass)->first();
        if ($result != null) {
            Session::put('username', $result->staff_name);
            Session::put('id', $result->staff_id);
            return redirect('/show-dashboard');
        } else {
            Session::put('ErrorMessage', 'Tên đăng nhập hoặc mật khẩu chưa chính xác');
            return redirect('/');
        }
    }

}
