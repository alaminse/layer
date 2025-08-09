<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    public function index()
    {

        try{
            $data = Role::get();
            return view('role.index', compact('data'));

        }catch (\Exception $e) {

            Toastr::error(__("common.Something Went Wrong"));
            return back();
        }


    }

    public function store(Request $request)
    {

        try {
            Role::create($request->except("_token"));
            Toastr::success(__('common.Role Create Successful'), __('common.Success'));
            return redirect()->route('roles.index');
        } catch (\Exception $e) {

            return back();
        }
    }

    public function edit(Role $role)
    {
        try {
            $data = Role::get();
            return view('role.index', compact('data', 'role'));
        } catch (\Exception $e) {
            Toastr::error(__("common.Something Went Wrong"), __('common.Failed'));
            return redirect()->back();
        }
    }

    public function update(Request $request, Role $role)
    {
        try {
            $role->update($request->except("_token"));
            Toastr::success(__('common.Role Update Successful'), __('common.Success'));
            return redirect()->route('roles.index');
        } catch (\Exception $e) {
            return redirect()->route('roles.index');
        }
    }

    public function destroy(Role $role)
    {
        try {
            $delete = $role->delete();

            if ($delete){
                Toastr::success(__('common.Role Delete Successful'), __('common.Success'));
            } else{
                Toastr::error(__('common.Role is assign to staffs.'));
            }
            return redirect()->back();
        } catch (\Exception $e) {

            return redirect()->back();
        }
    }

    public function editPermission(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($item) {
            return explode('.', $item->name)[0]; // Group by prefix before the dash
        });

        return view('role.assign_permission', compact('role', 'permissions'));
    }

    public function assignPermission(Request $request)
    {
        // $user = User::find(1);
        // $user->assignRole('Super Admin');
        // $user->roles;

        // return null;

        $validator = Validator::make($request->all(), [
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|array',
            'permission_id.*' => 'exists:permissions,name',
        ]);

        if ($validator->fails()) {
            Toastr::error(__('Invalid data provided.'), __('common.Failed'));
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $role = Role::findOrFail($request->role_id);
        $permissions = Permission::whereIn('name', $request->permission_id)->pluck('name')->toArray();
        $role->syncPermissions($permissions);

        Toastr::success(__('Permission added successfully.'), __('common.Success'));

        return redirect()->route('roles.index');
    }

    // this is specific user permission
    // $user = User::find(1);

    // $permissions = Permission::pluck('name')->toArray();

    // $user->syncPermissions($permissions);
    // return redirect()->route('roles.index');
    // Toastr::success(('Permession add successfully.'), __('common.Success'));


    // public function roleUsers(Request $request)
    // {
    //     $repo = new UserRepository();
    //     $users = $repo->staffs($request->role_id);

    //     if (count($users) > 0)
    //     {
    //         $output ='<option value="">'.trans('common.Select One').'</option>';
    //         foreach ($users as $user)
    //         {
    //             $output .= '<option value="'.$user->id.'">'.$user->name.'</option>';
    //         }
    //     }
    //     else
    //         $output = '<option>'.trans('common.No data Found').'</option>';

    //     return $output;
    // }
}
