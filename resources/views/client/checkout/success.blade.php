@extends('layouts.client')
@section('content')
    <div class="success-message">
        <img id="icon-success" src="{{ asset('client.css/images/check.png') }}" alt="">
        <h1>Đặt hàng thành công!</h1>
        <p style="text-align:center">Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ liên hệ với bạn sớm nhất!</p>
        <table class="shop-table">
            <thead>
                <tr class="detail-order">
                    <th>Ảnh</th>
                    <th>Sản phẩm</th>
                    <th>Tổng</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Cart::content() as $row)
                    <tr class="cart-item">
                        <td><img src="{{ url($row->options->file) }}" alt=""></td>
                        <td>{{ $row->name }} <strong class="danger"> x {{ $row->qty }}</strong></td>
                        <td>{{ number_format($row->price, 0, ',', '.') }}đ</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <td colspan="3"><span>Tổng giá tiền:</span> <strong>{{ Cart::subtotal() }} Đ</strong></td>
            </tfoot>
        </table>
    </div>
@endsection
