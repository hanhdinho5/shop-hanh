<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller


{

    function __construct(){
        $this->middleware(function($request, $next){
            session(['module_active' => 'user']);
            return $next($request);
        });
    }
        
    function list(Request $request)
    {
        $list_act = ['delete'=>'Xoá'];

        $status = $request->input('status');
        if ($status == 'trash'){
            $list_act = [
                'restore'=>'Khôi phục',
                'forceDelete'=>'Xoá vĩnh viễn'
            ];
            $users = User::onlyTrashed()->simplepaginate(10);
        }else{
            $keyword = "";
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
    
            $users = User::where('name', 'LIKE', "%{$keyword}%")->simplepaginate(10);
        }
        $count_user_active = User::count();
        $count_user_trash = User::onlyTrashed()->count();
        $count = [$count_user_active, $count_user_trash];

        // dd($users->count());
        return view('admin.user.list', compact('users', 'count', 'list_act'));
    }

    function action(Request $request){
        $list_check = $request->input('list_check');
        // dd($list_check);
        if ($list_check){
            # Xoá id đang login nếu có trong $list_check
            foreach ($list_check as $k => $id){
                if (Auth::id() == $id){
                    unset($list_check[$k]);
                }
            }
            
            if (!empty($list_check)){
                if ($request->input('act') == 'delete'){
                    User::destroy($list_check);
                    return redirect('admin/user/list')->with('status', 'Bạn đã xoá thành công');
                }

                if ($request->input('act') == 'restore'){
                    User::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/user/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($request->input('act') == 'forceDelete'){
                    User::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/user/list')->with('status', 'Bạn đã xoá vĩnh viễn quản trị viên');
                }
            }
            return redirect('admin/user/list')->with('no', 'Bạn không thể thực hiện tác vụ với tài khoản của bạn');
        }else{
            return redirect('admin/user/list')->with('no', 'Bạn chưa chọn bản ghi trước khi thực hiện tác vụ');
        }
    }


    function add()
    {
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'email' => ':attribute không đúng định dạng'

            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu'
            ]
        );
        
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $id_max = User::max('id'); // Lấy id max trong user, chính là user vừa thêm
        $user = User::find($id_max);
        $user->roles()->attach($request->input('roles'), []);  // Cập nhật bảng lk user_role

        return redirect('admin/user/list')->with('status', 'Bạn vừa thêm quản trị mới thành công');
    }

    function delete($id){
        if ($id != Auth::id()){
            $user = User::find($id);
            $user->delete();

            return redirect('admin/user/list')->with('status', 'Bạn đã xoá 1 quản trị viên');
        } else {
            return redirect('admin/user/list')->with('no', 'Bạn không thể xoá chính mình');
        }
    }

    function edit(User $user){
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'roles'));
        // return $roles;
    }
    function update(Request $request, User $user){
        $request->validate(
            [
                'name' => 'required|string|max:225',
                'password' => 'required|string|min:8|confirmed',
                'email' => 'required|email|unique:users,email,'.$user->id,
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại trên hệ thống',

            ],
            [
                'name' => 'Tên người dùng',
                'password' => 'Mật khẩu',
                'email' => 'Email',
            ]

        );

        $user->update([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password'))
        ]);
        $user->roles()->sync($request->input('roles', []));


        return redirect('admin/user/list')->with('status', 'Bạn đã cập nhật thông tin thành công');
    }
}
