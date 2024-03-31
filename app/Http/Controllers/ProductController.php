<?php

namespace App\Http\Controllers;

use App\Models\Cat_product;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProductController extends Controller
{

    // function __construct()
    // {
    //     $list_cat_product = Cat_product::all();
    // }

    function product_cat(Request $request, $slug, $cat_id)
    {
        // Sắp xếp
        $col = 'id';
        $v_select = "asc";
        if ($request->input('select')) {
            $select = $request->input('select');
            if ($select == 1) {
                $v_select = 'asc';
                $col = 'name';
            }
            if ($select == 2) {
                $v_select = 'desc';
                $col = 'name';
            }
            if ($select == 3) {
                $v_select = 'asc';
                $col = 'price';
            }
            if ($select == 4) {
                $v_select = 'desc';
                $col = 'price';
            }
        }
        // $list_product = $list_product->paginate(3);
        $pr = '';  // Để lấy biến gửi sang view khi ko tồn tại r_price
        if ($request->input('r_price')) {
            $pr = $request->input('r_price');
            if ($pr == '<500')
                $list_product = Product::where('price', '<', 500000)->where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);

            if ($pr == '500-1000')
                $list_product = Product::where('price', '>=', 500000)->where('price', '<=', 1000000)->where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);

            if ($pr == '1000-5000')
                $list_product = Product::where('price', '>=', 1000000)->where('price', '<=', 5000000)->where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);

            if ($pr == '5000-10000')
                $list_product = Product::where('price', '>=', 5000000)->where('price', '<=', 10000000)->where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);

            if ($pr == '>10000')
                $list_product = Product::where('price', '>', 10000000)->where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);
        } else
            $list_product = Product::where('cat_id', $cat_id)->orderBy($col, $v_select)->paginate(36);    // Từ Cat lấy ra các sản phẩm thuộc cat 

        $cat_active = Cat_product::find($cat_id)->name;          // Lấy tên cat

        $list_cat_product = Cat_product::all();
        $result_cat = data_tree($list_cat_product);
        $menu = render_menu($result_cat, 'list-item', 'sub-menu');

        return view('client.product.product_cat', compact('list_product', 'menu', 'cat_active', 'pr'));
    }

    function show(Request $request)
    {
        $keyword = '';
        if ($request->input('k'))
            $keyword = $request->input('k');
        if ($request->input('keyword'))
            $keyword = $request->input('keyword');

        // Sắp xếp
        $col = 'id';
        $v_select = "asc";
        if ($request->input('select')) {
            $select = $request->input('select');
            if ($select == 1) {
                $v_select = 'asc';
                $col = 'name';
            }
            if ($select == 2) {
                $v_select = 'desc';
                $col = 'name';
            }
            if ($select == 3) {
                $v_select = 'asc';
                $col = 'price';
            }
            if ($select == 4) {
                $v_select = 'desc';
                $col = 'price';
            }
        }

        $pr = '';  // Để lấy biến gửi sang view khi ko tồn tại r_price
        if ($request->input('r_price')) {
            $pr = $request->input('r_price');
            if ($pr == '<500')
                $list_product = Product::where('price', '<', 500000)->where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);

            if ($pr == '500-1000')
                $list_product = Product::where('price', '>=', 500000)->where('price', '<=', 1000000)->where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);

            if ($pr == '1000-5000')
                $list_product = Product::where('price', '>=', 1000000)->where('price', '<=', 5000000)->where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);

            if ($pr == '5000-10000')
                $list_product = Product::where('price', '>=', 5000000)->where('price', '<=', 10000000)->where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);

            if ($pr == '>10000')
                $list_product = Product::where('price', '>', 10000000)->where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);
        } else
            $list_product = Product::where('name', 'LIKE', "%{$keyword}%")->orderBy($col, $v_select)->paginate(36);

        $list_cat_product = Cat_product::all();
        $result_cat = data_tree($list_cat_product);
        $menu = render_menu($result_cat, 'list-item', 'sub-menu');


        return view('client.product.show', compact('list_product', 'menu', 'pr', 'keyword'));
    }

    function detail($slug, $id)
    {
        $product_detail = Product::find($id);
        $list_together_cat_product = Product::where('cat_id', $product_detail->cat_id)->paginate(10);
        
        $list_cat_product = Cat_product::all();
        $result_cat = data_tree($list_cat_product);
        $menu = render_menu($result_cat, 'list-item', 'sub-menu');

        return view('client.product.detail', compact('list_cat_product', 'product_detail', 'list_together_cat_product', 'menu'));
    }

    function seach_product_ajax(Request $request)
    {
        $keyword = $request->input('keyword');
        $products = Product::where('name', 'LIKE', "%$keyword%")->paginate(10);
        $str = '';
        foreach ($products as $value) {
            $url_pr_detail = route('product.detail', [$value->slug, $value->id]);
            $url_img = url($value->img);
            $str .= "
            <li class='d-flex border-bottom'>
                <a href='$url_pr_detail'><img src='$url_img'alt=''></a>
                <a href='$url_pr_detail'><p>$value->name<p></a>
            </li>
            ";
        }
        $data = [
            'str' => $str,
        ];
        return json_encode($data);
    }
}
