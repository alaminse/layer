<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Brian2694\Toastr\Facades\Toastr;

class PermissionController extends Controller
{
    
    public function index()
    {
        try{
            $data = Permission::get();
            return view('permission.index', compact('data'));

        }catch (\Exception $e) {

            Toastr::error(__("common.Something Went Wrong"));
            return back();
        }


    }

    public function store(Request $request)
    {
        try {
            Permission::create($request->except("_token"));
            Toastr::success('Permission Create Successful', __('common.Success'));
            return redirect()->route('permissions.index');
        } catch (\Exception $e) {

            return back();
        }
    }

    public function edit(Permission $permission)
    {
        try {
            $data = Permission::get();
            return view('permission.index', compact('data', 'permission'));
        } catch (\Exception $e) {
            Toastr::error(__("common.Something Went Wrong"), __('common.Failed'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Permission $permission)
    {
        try {
            $permission->update($request->except("_token"));
            Toastr::success(__('common.Role Update Successful'), __('common.Success'));
            return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            return redirect()->route('permissions.index');
        }
    }

    public function destroy(Permission $permission)
    {
        try {
            $delete = $permission->delete();

            if ($delete){
                Toastr::success('Permission Delete Successful', __('common.Success'));
            } else{
                Toastr::error(__('common.Permission is assign to staffs.'));
            }
            return redirect()->back();
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    

    public function assignPermission(Request $request)
    {
        // $repo = new UserRepository();
        // $users = $repo->staffs($request->role_id);

        // if (count($users) > 0)
        // {
        //     $output ='<option value="">'.trans('common.Select One').'</option>';
        //     foreach ($users as $user)
        //     {
        //         $output .= '<option value="'.$user->id.'">'.$user->name.'</option>';
        //     }
        // }
        // else
        //     $output = '<option>'.trans('common.No data Found').'</option>';

        // return $output;
    }
}
