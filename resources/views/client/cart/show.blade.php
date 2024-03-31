@extends('layouts.client')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <div id="main-content-wp" class="cart-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Sản phẩm làm đẹp da</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            <div class="section" id="info-cart-wp">
                <div class="section-detail table-responsive">
                    <form action="{{ route('cart.update') }}" method="POST">
                        @csrf
                        <table class="table" style="min-height: 370px;">
                            <thead>
                                <tr>
                                    <td>Mã sản phẩm</td>
                                    <td>Ảnh sản phẩm</td>
                                    <td>Tên sản phẩm</td>
                                    <td>Giá sản phẩm</td>
                                    <td>Số lượng</td>
                                    <td colspan="2">Thành tiền</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (Cart::content() as $item)
                                    <tr>
                                        <td>{{ $item->options->code_product}}</td>
                                        <td>
                                            <a href="{{route('product.detail', [Str::slug($item->name), $item->id])}}" title="" class="thumb">
                                                <img src="{{ url($item->options->file) }}" alt="">
                                            </a>
                                        </td>
                                        <td>
                                            <a href="" title="" class="name-product">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ number_format($item->price, 0, ',', '.') }}đ</td>
                                        <td>
                                            <input type="number" id="{{$item->rowId}}" data-price="{{$item->price}}" data-rowId="{{ $item->rowId }}" name="num-order"
                                                min="1" max="20" value="{{ $item->qty }}" class="num-order">
                                        </td>
                                        <td id="subtotal{{$item->rowId}}">{{ number_format($item->qty * $item->price, 0, ',', '.') }}đ</td>
                                        <td>
                                            <a href="{{ route('cart.delete', $item->rowId) }}" title=""
                                                class="del-product"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-danger">Không tồn tại sản phẩm nào, click <a
                                                href="{{ route('product.show') }}">Vào đây</a> để mua hàng</td>
                                    </tr>
                                @endforelse

                            </tbody>
                            @if (Cart::count() > 0)
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <p id="total-price" class="fl-right">Tổng giá:
                                                <span id="total_many">{{ Cart::subtotal() }}đ</span></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="7">
                                        <div class="clearfix">
                                            <div class="fl-right">
                                                {{-- <a href="" title="" id="update-cart">Cập nhật giỏ hàng</a> --}}
                                                <a href="{{route('checkout')}}" title="" id="checkout-cart">Thanh toán</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </form>
                </div>
            </div>
            <div class="section" id="action-cart-wp">
                <div class="section-detail">
                    <p class="title"> Thay đổi số lượng sản phẩm tại số lượng. Nhấn vào thanh toán để mua hàng.</p>
                    <a href="{{ route('product.show') }}" title="" id="buy-more">Mua tiếp</a><br />
                    <a href="{{ route('cart.destroy') }}" title="" id="delete-cart">Xóa giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection
