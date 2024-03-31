<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmOrder;
use App\Models\Order;
use App\Models\District;
use App\Models\Product;
use App\Models\Province;
use App\Models\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\Mail;
class CheckoutController extends Controller
{
    function checkout()
    {
        $province = Province::all();
        // return $province;
        return view('client.checkout.checkout', compact('province'));
    }
    function checkout_fast($id){
        $product = Product::find($id);
        // dd($product);
        Cart::add([
            'id' => $id,
            'name' => $product->name,
            'qty' => 1,
            'price' => $product->price,
            'options' => ['file' => $product->img, 'code_product' => '#code'.$id],
        ]);
        return redirect()->route('checkout');
    }
    function confirm_checkout(Request $request)
    {
        $request->validate(
            [
                'fullname' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|',
                'address' => 'required',
                'phone' => ['required', 'regex:/\b\d{3}[-.]?\d{3}[-.]?\d{4}\b/'],
                'province' => 'required',
                'district' => 'required',
                'commune' => 'required',

            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ đài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'phone' => ':attribute không đúng định dạng',
                'regex' => ':attribute không đúng định dạng',
            ],
            [
                'fullname' => 'Họ tên',
                'email' => 'Email',
                'phone' => 'SĐT',
                'address' => 'Địa chỉ',
                'commune' => 'Xã/Thị trấn',
                'district' => 'Quận/Huyện',
                'province' => 'Tỉnh/Thành phố',
            ]
        );
        $code_order = '#ORDER' . Str::random(5);

        $details = Cart::content();
        $order_details = json_encode($details);

        $name_wards = Ward::where('wards_id', $request->input('commune'))->first();
        $name_district = District::where('district_id', $request->input('district'))->first();
        $name_province = Province::where('province_id', $request->input('province'))->first();

        Order::create([
            'code' => $code_order,
            'client' => $request->input('fullname'),
            'email' => $request->input('email'),
            'quantity' => Cart::count(),
            'total_price' => Cart::subtotal(),
            'phone' => $request->input('phone'),
            // 'status' => 0,
            'address' => $request->input('address') . '-' . $name_wards->name . '-' . $name_district->name . '-' . $name_province->name,
            'detail' => $order_details,
        ]);

        // Gửi data sang senmail 
        $data_client = [
            'code' => $code_order,
            'client' => $request->input('fullname'),
            'email' => $request->input('email'),
            'quantity' => Cart::count(),
            'total_price' => Cart::content()->sum('price'),
            'phone' => $request->input('phone'),
            'status' => 0,
            'address' => $request->input('address') . '-' . $name_wards->name . '-' . $name_district->name . '-' . $name_province->name,
        ];
        Mail::to($request->email)->send(new ConfirmOrder($data_client));

        return redirect()->route('order.success');
    }

    function success()
    {
        return view('client.checkout.success');
    }


    // Xử lý chọn tỉnh thành, huyện , phường
    function handle_ajax_district(Request $request)
    {
        $province_id = $request->input('province_id');
        $list_dictricts = District::where('province_id', $province_id)->get();
        $data[0] =[
            'id' => null,
            'name' => "---- Chọn Quận/Huyện ----",
        ];
        foreach ($list_dictricts as $item){
            $data[] = [
                'id' => $item->district_id,
                'name' =>$item->name
            ];
        }

        echo json_encode($data);
    }

    function handle_ajax_wards(Request $request){
        $district_id= $request->input("district_id");
        $list_wards = Ward::where('district_id', $district_id)->get();
        $data[0] = [
            'id' => null,
            'name' => "---- Chọn Xã/Thị trấn ----",
        ];
        foreach ($list_wards as $item){
            $data[] = [
                'id' => $item->wards_id,
                'name' =>$item->name
            ];
        }

        echo json_encode($data);
    }







}
