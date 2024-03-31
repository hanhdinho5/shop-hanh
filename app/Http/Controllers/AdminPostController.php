<?php

namespace App\Http\Controllers;

use App\Models\Cat_post;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'post']);
            return $next($request);
        });
    }

    //===== POST =========
    function list(Request $request)
    {
        $list_act = ['delete' => 'Xoá'];

        if ($request->input('status') == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xoá vĩnh viễn'];
            $posts = Post::onlyTrashed()->simplepaginate(10);
        } else {
            $keyword = '';
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $posts = Post::where('name', 'LIKE', "%{$keyword}%")->simplepaginate(10);
        }

        $count_post_active = Post::count();
        $count_post_trash = Post::onlyTrashed()->count();
        $count = [$count_post_active, $count_post_trash];

        return view('admin.post.list', compact('posts', 'list_act', 'count'));
    }
    //------------------------------------------------------------------------
    function action(Request $request)
    {
        if ($request->input('list_check')) {
            $list_check = $request->input('list_check');
            $action = $request->input('act');

            if (!empty($list_check)) {
                if ($action == 'delete') {
                    Post::destroy($list_check);
                    return redirect('admin/post/list')->with('status', 'Bạn đã xoá thành công');
                }

                if ($action == 'restore') {
                    Post::withTrashed()->whereIn('id', $list_check)->restore();
                    return redirect('admin/post/list')->with('status', 'Bạn đã khôi phục thành công');
                }

                if ($action == 'forceDelete') {
                    Post::withTrashed()->whereIn('id', $list_check)->forceDelete();
                    return redirect('admin/post/list')->with('status', 'Bạn đã xoá vĩnh viễn');
                }
                return redirect('admin/post/list')->with('no', 'Bạn chưa chọn tác vụ để áp dụng');

            }
        } else {
            return redirect('admin/post/list')->with('no', 'Bạn chưa chọn bản ghi nào');
        }
    }



    function add()
    {
        return view('admin.post.add');
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:6|max:100',
                'content' => 'required|string|min:10',
                'file' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        if ($request->hasFile('file')){
            $file = $request->file;
            $name_file = $file->getClientOriginalName();
            $path_file =  $file->move('public/upload/posts', $name_file);
        }

        Post::create([
            'name' => $request->input('name'),
            'content' => $request->input('content'),
            'img' => $path_file
        ]);

        return redirect('admin/post/list')->with('status', 'Bạn đã thêm bài viết mới thành công');
    }


    //------------------------------------------------------------------------

    function delete($id)
    {
        Post::find($id)->delete();
        return redirect('admin/post/list')->with('status', 'Bạn đã xoá 1 bài viết thành công');
    }
    function edit($id)
    {
        $post = Post::find($id);
        return view('admin.post.edit', compact('post'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|min:6|max:200',
                'content' => 'required|string|min:10'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tiêu đề',
                'content' => 'Nội dung'
            ]
        );
        Post::where('id', $id)->update([
            'name' => $request->input('name'),
            'content' => $request->input('content')
        ]);
        return redirect('admin/post/list')->with('status', 'Bạn đã cập nhật thành công');
    }



    // ========  CAT POST ==========

    function list_cat()
    {
        $cat_post = Cat_post::simplepaginate(6);
        return view('admin.cat_post.list', compact('cat_post'));
    }
    //------------------------------------------------------------------------

    function add_cat(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:6|max:20',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên danh mục',
            ]
        );

        Cat_post::create([
            'cat_post' => $request->input('name'),
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Bạn đã thêm danh mục thành công');
    }
    //------------------------------------------------------------------------
    function edit_cat($id)
    {
        $cat_post = Cat_post::find($id);
        return view('admin.cat_post.edit', compact('cat_post'));
    }
    function update_cat(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|min:6|max:20',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên danh mục',
            ]
        );

        Cat_post::where('id', $id)->update([
            'cat_post' => $request->input('name')
        ]);
        return redirect('admin/post/cat/list')->with('status', 'Bạn đã cập nhật danh mục thành công');
    }
    //------------------------------------------------------------------------
    function delete_cat($id)
    {
        Cat_post::find($id)->delete();
        return redirect('admin/post/cat/list')->with('status', 'Bạn đã xoá 1 danh mục thành công');
    }
}
