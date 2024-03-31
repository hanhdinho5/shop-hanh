<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cat_product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class AdminProductController extends Controller
{
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'product']);
            return $next($request);
        });

        // function data_tree($cat_products, $parent_id = 0, $level = 0)
        // {
        //     $result = array();
        //     foreach ($cat_products as $v) {
        //         if ($v->parent_id == $parent_id) {
        //             $v['level'] = $level;
        //             $result[] = $v;
        //             foreach ($cat_products as $v1) {
        //                 if ($v1->parent_id == $v->id) {
        //                     $result_child = data_tree($cat_products, $v->id, $level+1);
        //                     $result = array_merge($result, $result_child);
        //                 }
        //             }
        //         }
        //     }
        //     return $result;
        // }

        function data_tree($data_src, $parent_id = 0, $level = 0)
        {
            $result = array();
            foreach ($data_src as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    $child = data_tree($data_src, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
            return $result;
        }

    }

    // ===== Product ============

    // function test(){
    //     // $cat = Product::find(6)->cat_pr;
    //     $cat = Product::find(2)->cat;

    //     return $cat->name;
    // }

    function list(Request $request)
    {
        $list_act = ['delete' => 'Xoá'];
        $status = $request->input('status');
        if ($status == 'trash') {
            $list_act = ['restore' => 'Khôi phục', 'forceDelete' => 'Xoá vĩnh viễn'];
            $products = Product::onlyTrashed()->paginate(8);
        } else {
            $keyword = '';
            if (!empty($request->input('keyword'))) {
                $keyword = $request->input('keyword');
            }
            $products = Product::where('name', 'LIKE', "%{$keyword}%")->paginate(8);
            foreach ($products as $item) {
                $item['cat_id'] = Product::find($item['id'])->cat->name;
            }
        }
        $count_product_active = Product::count();
        $count_product_trash = Product::onlyTrashed()->count();
        $count = [$count_product_active, $count_product_trash];

        return view('admin.product.list', compact('products', 'list_act', 'count'));
    }

    function action(Request $requerst)
    {
        if ($requerst->input('list_check')) {
            $list_check = $requerst->input('list_check');
            $act = $requerst->input('act');

            if ($act == 'delete') {
                Product::destroy($list_check);
                return redirect('admin/product/list')->with('status', 'Bạn đã xoá thành công');
            }

            if ($act == 'restore') {
                Product::withTrashed()->whereIn('id', $list_check)->restore();
                return redirect('admin/product/list')->with('status', 'Bạn đã khôi phục thành công');
            }

            if ($act == 'forceDelete') {
                Product::withTrashed()->whereIn('id', $list_check)->forceDelete();
                return redirect('admin/product/list')->with('status', 'Bạn đã xoá vĩnh viễn thành công');
            }
            return redirect('admin/product/list')->with('no', 'Bạn chưa chọn tác vụ cần áp dụng');
        } else {
            return redirect('admin/product/list')->with('no', 'Bạn chưa chọn bản ghi nào');
        }
    }


    function edit($id)
    {
        $cat_product = Cat_product::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product', 'cat_product'));
    }
    function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|min:5|max:100',
                'price' => 'required|string|integer|min:4',
                'cat_id' => 'required',
                'intro' => 'required',
                'detail' => 'required',
                'exampleRadios' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'integer' => ':attribute phải dạng số '
            ],
            [
                'name' => 'Tiêu đề',
                'price' => 'Giá sản phẩm',
                'cat_id' => 'Danh mục sản phẩm',
                'intro' => 'Mô tả',
                'detail' => 'Chi tiết',
                'exampleRadios' => 'Trạng thái'
            ]
        );
        Product::where('id', $id)->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'cat_id' => $request->input('cat_id'),
            'des' => $request->input('intro'),
            'detail' => $request->input('detail'),
            'status' => $request->input('exampleRadios'),
        ]);
        return redirect('admin/product/list')->with('status', 'Bạn đã cập nhật thành công');
    }


    function add()
    {
        $cat_product = Cat_product::where('parent_id', '0')->get();
        return view('admin.product.add', compact('cat_product'));
    }
    function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:5|max:50',
                'price' => 'required|string|integer|min:4',
                'cat_id' => 'required',
                'intro' => 'required',
                'detail' => 'required',
                'file' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'integer' => ':attribute phải dạng số '
            ],
            [
                'name' => 'Tiêu đề',
                'price' => 'Giá sản phẩm',
                'cat_id' => 'Danh mục sản phẩm',
                'intro' => 'Mô tả',
                'detail' => 'Chi tiết',
            ]
        );

        if ($request->hasFile('file')) {
            $file = $request->file;
            // $name_file = $file->getClientOriginalName();   // Lấy tên file
            $path_file = $file->move('public/upload/product',  $file->getClientOriginalName());
        }
        $slug = Str::slug($request->input('name'));
        Product::create([
            'img' => $path_file,
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'cat_id' => $request->input('cat_id'),
            'des' => $request->input('intro'),
            'detail' => $request->input('detail'),
            'slug' => $slug,
        ]);
        return redirect('admin/product/list')->with('status', 'Bạn đã thêm sản phẩm thành công');
    }

    function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect('admin/product/list')->with('status', 'Bạn đã xoá sản phẩm thành công');
    }



    //======= Cat Product =======


    function cat_list()
    {
        $cat_products = Cat_product::all();

        $result = data_tree($cat_products);
        // return dd($result);

        return view('admin.cat_product.list', compact('result'));
    }

    function cat_store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|min:2|max:20',
                'exampleRadios' => 'required',
                'parent' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên danh mục',
                'exampleRadios' => 'Trang thái',
                'parent' => 'Danh mục cha',
            ]
        );

        Cat_product::create([
            'name' => $request->input('name'),
            'parent_id' => $request->input('parent'),
            'status' => $request->input('exampleRadios'),
            'slug' => Str::slug($request->input('name')),
        ]);
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã thêm danh mục sản phẩm thành công');
    }

    function cat_edit($id)
    {
        $cat_product = Cat_product::find($id);
        $cat_products = Cat_product::all();
        $result = data_tree($cat_products);
        return view('admin.cat_product.edit', compact('cat_product', 'result'));
    }
    function cat_update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|string|min:2|max:20',
                'exampleRadios' => 'required',
                'parent' => 'required',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ đài ít nhất :min ký tự',
                'max' => ':attribute có độ đài tối đa :max ký tự',
            ],
            [
                'name' => 'Tên danh mục',
                'exampleRadios' => 'Trạng thái',
                'parent' => 'Danh mục',
            ]
        );
        // echo "ok";
        // return dd($request->input());

        Cat_product::where('id', $id)->update([
            'name' => $request->input('name'),
            'status' => $request->input('exampleRadios'),
            'parent_id' => $request->input('parent'),
            'slug' => Str::slug($request->input('name')),

        ]);
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã cập nhật danh mục sản phẩm thành công');
    }

    function cat_delete($id)
    {
        Cat_product::where('id', $id)->delete();
        return redirect('admin/product/cat/list')->with('status', 'Bạn đã xoá danh mục sản phẩm thành công');
    }
}
