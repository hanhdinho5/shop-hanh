<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);
            return $next($request);
        });
    }


    function list(Request $request)
    {
        $list_act = ['delete' => 'Xoá'];
        $status = $request->input('status') != null ? $request->input('status') : 'off';
        if ($status == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xoá vĩnh viễn'];
            $orders = Order::onlyTrashed()->orderBy('created_at', 'desc')->paginate(10);
        } else if ($status == 0) {
            $orders = Order::where('status', '0')->orderBy('created_at', 'desc')->paginate(10);
        } else if ($status == 1) {
            $orders = Order::where('status', '1')->orderBy('created_at', 'desc')->paginate(10);
        } else if ($status == 2) {
            $orders = Order::where('status', '2')->orderBy('created_at', 'desc')->paginate(10);
        } else if ($status == 3) {
            $orders = Order::where('status', '3')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $keyword = '';
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $orders = Order::where('code', 'LIKE', "%{$keyword}%")->orderBy('created_at', 'desc')->paginate(10);
        }

        $count_0 = Order::where('status', '0')->count();
        $count_1 = Order::where('status', '1')->count();
        $count_2 = Order::where('status', '2')->count();
        $count_3 = Order::where('status', '3')->count();
        $count_order_active = Order::count();
        $count_order_trash = Order::onlyTrashed()->count();
        $count = [$count_0, $count_1, $count_2, $count_3, $count_order_active, $count_order_trash];

        $total_revenue = 0;
        $list_complete = Order::where('status', '2')->get();
        foreach ($list_complete as $item){
            $total_revenue += intval(str_replace(',', '', $item->total_price));
        }
        // return $total;

        return view('admin.order.list', compact('orders', 'count', 'list_act', 'total_revenue'));
    }


    function edit($id){
        $info_order = Order::find($id);
        return view('admin.order.edit', compact('info_order'));
    }
    function update(Request $request, $id){
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'tel' => ['required', 'regex:/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/'],
                'address' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'email' => ':attribute không đúng định dạng',
                'regex' => ':attribute không đúng định dạng',

            ],
            [
                'name' => 'Tên khách hàng',
                'email' => 'Email',
                'tel' => 'Số điện thoại',
                'address' => 'Địa chỉ',
            ]
        );
        Order::where('id', $id)->update([
            'client' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('tel'),
            'address' => $request->input('address'),
        ]);
        return redirect('admin/order/list')->with('status', 'Bạn đã cập nhật thành công!');

    }


    function action(Request $request)
    {
        if ($request->input('list_check')) {
            $list_check = $request->input('list_check');
            $act = $request->input('act');
            if ($act == 'delete') {
                Order::destroy($list_check);
                return redirect('admin/order/list')->with('status', 'Bạn đã xoá thành công');
            }
            if ($act == 'restore') {
                Order::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/order/list')->with('status', 'Bạn đã khôi phục thành công');
            }
            if ($act == 'forceDelete') {
                Order::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/order/list')->with('status', 'Bạn đã xoá vĩnh viễn thành công');
            }
            return redirect('admin/order/list')->with('no', 'Bạn chưa chọn tác vụ cần áp dụng');
        } else {
            return redirect('admin/order/list')->with('no', 'Bạn chưa chọn bản ghi nào');
        }
    }


    function delete($id)
    {
        Order::find($id)->delete();
        return redirect('admin/order/list')->with('status', 'Bạn đã xoá một đơn hàng thành công');
    }

    function detail($id)
    {
        $detail_info = Order::find($id);
        $status = $detail_info->status; // Lấy trạng thái
        $detail_order = json_decode($detail_info->detail);

        return view('admin.order.detail', compact('detail_info', 'detail_order', 'status', 'id'));
    }
    function update_status_order(Request $request){
        $status = $request->input('status');
        $id = $request->input('id');
        Order::where('id', $id)->update([
            'status' => $status,
        ]);
        return redirect()->route('order.detail', $id)->with('ok', 'Cập nhật trạng thái thành công');
    }




}
