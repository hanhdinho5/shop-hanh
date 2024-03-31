<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\all;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }


    function list()
    {

        $roles = Role::all();
        return view('admin.role.list', compact('roles'));
    }


    function delete(Role $role){
        $role->delete();
        return redirect()->route('role.list')->with('ok', 'Xoá vai trò thành công!');

    }


    function edit(Role $role){
        $permissions = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        // return $role;
        return view('admin.role.edit', compact('role', 'permissions'));
    }
    function update(Request $request, Role $role){
        $request->validate(
            [
                'name' => 'required|max:225|unique:roles,name,'.$role->id,
                'description' => 'required',
                'permission_id'=> 'nullable|array',
                'permission_id.*' => 'exists:permissions,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute ký tự tối đa :max ký tự',
                'unique' => ':attribute đã tồn tại trên hệ thống',
                'array' => ':attribute không phải mảng',
                'exists' => ':attribute không tồn tại quyền này trên hệ thống',
            ],
            [
                'name' => 'Tên vai trò',
                'description' => 'Mô tả vai trò'
            ]

        );
        $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);
        $role->permissions()->sync($request->input('permission_id', []));

        return redirect()->route('role.list')->with('ok', 'Cập nhật thành công!');

    }



    function add()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        // dd($permissions);
        return view('admin.role.add', compact('permissions'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:225|unique:roles,name',
                'description' => 'required',
                'permission_id'=> 'nullable|array',
                'permission_id.*' => 'exists:permissions,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => 'attribute ký tự tối đa :max ký tự'
            ],
            [
                'name' => 'Tên vai trò',
                'description' => 'Mô tả vai trò'
            ]
        );

        $role = Role::create([
            'name'=>$request->input('name'),
            'description'=> $request->input('description'),
        ]);

        $role->permissions()->attach($request->input('permission_id'));

        return redirect()->route('role.list')->with('ok', 'Bạn đã thêm vai trò thành công!');
    }







}
