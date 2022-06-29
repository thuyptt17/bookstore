<?php

namespace App\Http\Controllers;
use Session;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
session_start();

class StaffController extends Controller
{
    public function showStaff()
    {
        $staff_id = Session::get('id');
        $staff = DB::table('tbl_staff')->where('staff_id',$staff_id)->first();
        $all_staff = DB::table('tbl_staff')->get();
        return view('management.staff.show_staff')->with('all_staff', $all_staff)->with('staff',$staff);
    }

    public function addStaff(Request $request)
    {
        $data = array();
        $data['staff_name'] = $request->name;
        $data['staff_phone'] = $request->phone;
        $data['staff_address'] = $request->address;
        $data['staff_email'] = $request->email;
        $data['staff_startdate'] = $request->date;
        $data['staff_position'] = $request->position;
        $data['staff_salary'] = $request->salary;
        $data['staff_password'] = 12345;
        DB::table('tbl_staff')->insert($data);
        Session::put('message', 'Thêm nhân viên thành công');
        return redirect('/show-staff');
    }

    public function updateStaff(Request $request, $id)
    {
        $data = array();
        $data['staff_name'] = $request->name;
        $data['staff_phone'] = $request->phone;
        $data['staff_address'] = $request->address;
        $data['staff_email'] = $request->email;
        $data['staff_startdate'] = $request->date;
        $data['staff_position'] = $request->position;
        $data['staff_salary'] = $request->salary;
        $data['staff_password'] = md5($request->password);

        DB::table('tbl_staff')->where('staff_id', $id)->update($data);
        Session::put('message', 'Cập nhật nhân viên thành công');
        return redirect('/show-staff');       
    }

    
    public function deleteStaff($id)
    {
        DB::table('tbl_staff')->where('staff_id', $id)->delete();
        Session::put('message', 'Xóa nhân viên thành công');
        return redirect('/show-staff');
    }
}
