<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

use Illuminate\Support\Facades\Auth;

class AdminPageController extends Controller
{

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'page']);
            return $next($request);
        });
    }
//------------------------------------------------------------------------

    function list(Request $request)
    {   
        $list_act = ['delete'=> 'Xoá'];

        if ($request->input('status') == 'trash'){
            $list_act = ['forcedelete'=> 'Xoá vĩnh viễn', 'restore'=> 'Khôi phục'];
            $pages = Page::onlyTrashed()->simplepaginate(10);

        }else{
            $keyword = '';
            if (!empty($request->keyword)){
                $keyword = $request->keyword;
            }
            $pages = Page::where('title', 'LIKE', "%{$keyword}%")->simplepaginate(10);
        }
        
        $count_page_active = Page::count();
        $count_page_trash = Page::onlyTrashed()->count();
        $count = [$count_page_active, $count_page_trash];
       
        return view('admin.page.list', compact('pages', 'list_act', 'count'));
    }
    
//------------------------------------------------------------------------
    function active(Request $request){
        $list_check = $request->input('checkbox');
        if ($list_check){
            if ($request->act == 'delete'){
                Page::destroy($list_check);
                return redirect('admin/page/list')->with('status', 'Bạn đã xoá thành công');

            }
            if ($request->act == 'restore'){
                Page::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/page/list')->with('status', 'Bạn đã khôi phục thành công');

            }
            if ($request->act == 'forcedelete'){
                Page::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/page/list')->with('status', 'Bạn đã xoá vĩnh viễn trang');
            }
        }else
            return redirect('admin/page/list')->with('no', 'Bạn chưa chọn bản ghi nào');
    }

//------------------------------------------------------------------------

    function delete($id){
            Page::find($id)->delete();
            return redirect('admin/page/list')->with('status', 'Bạn đã xoá 1 trang thành công');
    }
//------------------------------------------------------------------------

    function edit($id){
        $page = Page::find($id);

        return view('admin.page.edit', compact('page'));
    }
    function update(Request $request, $id){
        $request->validate(
            [
                'name'=> 'required|string|min:6|max:20',
                'content'=> 'required|string|min:10'
            ],
            [
                'required'=> ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name'=> 'Tiêu đề',
                'content'=> 'Nội dung'
            ]
        );
        Page::where('id', $id)->update([
            'title'=> $request->input('name'),
            'content'=> $request->input('content'),
        ]);
        return redirect('admin/page/list')->with('status', 'Bạn đã cập nhật thành công trang');
    }
//------------------------------------------------------------------------

    function add()
    {
        return view('admin.page.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name'=> 'required|string|min:6|max:20',
                'content'=> 'required|string|min:10'
            ],
            [
                'required'=> ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name'=> 'Tiêu đề',
                'content'=> 'Nội dung'
            ]
        );

        Page::create([
            'title'=> $request->input('name'),
            'content'=> $request->input('content')
        ]);

        return redirect('admin/page/list')->with('status', 'Bạn đã thêm trang mới thành công');
    }
}
