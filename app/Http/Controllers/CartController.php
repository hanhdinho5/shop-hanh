<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;

class CartController extends Controller
{

    function add(Request $request, $id)
    {
        $qty = 1;
        if ($request->input('num-order'))
            $qty = $request->input('num-order');


        $product = Product::find($id);

        // Cart::destroy();
        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'options' => ['file' => $product->img, 'code_product' => '#code'.$id],
        ]);
        // echo "<pre>";
        // print_r(Cart::content());
        return redirect()->route('cart.show');
    }

    function show()
    {
        return view('client.cart.show');
    }

    function delete($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('cart.show');
    }
    function destroy()
    {
        Cart::destroy();
        return redirect()->route('cart.show');
    }


    function add_ajax(Request $request){
        $id_product = $request->input('id_product');
        $product = Product::find($id_product);
        $qty = 1;
        if ($request->input('qty'))
            $qty = $request->input('qty');
        Cart::add([
            'id' => $id_product,
            'name' => $product->name,
            'qty' => $qty,
            'price' => $product->price,
            'options' => ['file' => $product->img, 'code_product' => '#code'.$id_product],
        ]);

        $total = Cart::subtotal();
        $count = Cart::count();
        $data = [
            'total' => $total,
            'count' => $count,
        ];
        echo json_encode($data);
    }

    function update(Request $request)
    { {
            $rowId = $request->input('rowId');
            $qty = $request->input('qty');
            $price = $request->input('price');
            // tổng tiền 1 sản phẩm
            $subtotal = $qty * $price;
            // Cập nhật qty
            Cart::update($rowId, ['qty' => $qty]);
            // Lấy tổng tiền khi đã cập nhật qty (ngay trên)
            $total = Cart::subtotal();
            // Đếm sản phẩm giỏ hàng
            $count = Cart::count();

            $data = [
                'rowId' => $rowId,
                'subtotal' => number_format($subtotal, 0, ',', '.'),
                'qty' => $qty,
                'total' => $total,
                'count' => $count,
            ];

            echo json_encode($data);
        }
    }
}
