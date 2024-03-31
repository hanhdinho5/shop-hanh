<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'permission']);
            return $next($request);
        });
    }

    function delete($id){
        Permission::find($id)->delete();

        return redirect()->route('permission.add')->with('ok', 'Bạn đã xoá quyền thành công');
    }


    function edit($id){
        $permissions = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        $permission = Permission::find($id);

        return view('admin.permission.edit', compact('permission', 'permissions'));
    }
    function update(Request $request, $id){
        $validated = $request->validate(
            [
                'name' => 'required|max:225',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute không được vượt quá :max kí tự'
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );
        Permission::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('des'),
        ]);
        return redirect('admin/permission/add')->with('ok', 'Cập nhật thành công');
    }



    function add()
    {
        $permissions = Permission::all()->groupBy(function($permission){
            return explode('.', $permission->slug)[0];
        });
        // dd($permissions);


        return view('admin.permission.list', compact('permissions'));
    }
    function store(Request $request)
    {
        $validated = $request->validate(
            [
                'name' => 'required|max:225',
                'slug' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute không được vượt quá :max kí tự'
            ],
            [
                'name' => 'Tên quyền',
                'slug' => 'Slug',
            ]
        );
        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('des'),
        ]);
        return redirect()->route('permission.add')->with('ok', 'Đã thêm quyền thành công');
    }







}
