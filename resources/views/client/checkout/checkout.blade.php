@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="checkout-page">
        <div class="section" id="breadcrumb-wp">
            <div class="wp-inner">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="?page=home" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Thanh toán</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="wrapper" class="wp-inner clearfix">
            @if (session('ok'))
                <div class="alert alert-success">{{ session('ok') }}</div>
            @endif
            <form method="POST" action="{{ route('confirm_checkout') }}" name="form-checkout">
                @csrf
                <div class="section" id="customer-info-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin khách hàng</h1>
                    </div>
                    <div class="section-detail">
                        <div class="form-row clearfix">
                            <div class="form-col col-12 col-sm-6">
                                <label for="fullname">Họ tên</label>
                                <input type="text" name="fullname" id="fullname" value="{{ old('fullname') }}"
                                    class="form-control">
                                @error('fullname')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col col-12 col-sm-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col col-12 col-sm-6">
                                <label for="phone">Số điện thoại</label>
                                <input type="tel" name="phone" id="phone" value="{{ old('phone') }}"
                                    class="form-control">
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col col-12 col-sm-6">
                                <label for="province">Tỉnh/Thành phố:</label>
                                <select name="province" id="province" class="form-control">
                                    <option value="">---- Chọn tỉnh thành ----</option>
                                    @foreach ($province as $item)
                                        <option value="{{ $item->province_id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col col-12 col-sm-6">
                                <label for="district">Quận/Huyện</label>
                                <select name="district" id="district" class="form-control">
                                    <option value="" selected>---- Chọn Quận/Huyện ----</option>
                                    {{-- <option value="h1" {{ old('district') == 'h1' ? 'selected' : '' }}>H1</option>
                                    <option value="h2" {{ old('district') == 'h2' ? 'selected' : '' }}>H2</option> --}}
                                </select>
                                @error('district')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-col col-12 col-sm-6">
                                <label for="commune">Xã/Thị trấn</label>
                                <select name="commune" id="commune" class="form-control">
                                    <option value="" selected>---- Chọn Xã/Thị trấn ----</option>
                                    {{-- <option value="x1" {{ old('commune') == 'x1' ? 'selected' : '' }}>X1</option>
                                    <option value="x2" {{ old('commune') == 'x2' ? 'selected' : '' }}>X2</option> --}}
                                </select>
                                @error('commune')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row clearfix">
                            <div class="form-col col-12">
                                <label for="address">Địa chỉ</label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}"
                                    placeholder="Ngõ, thôn(bản)" class="form-control">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-col col-12">
                                <label for="notes">Ghi chú</label>
                                <textarea name="note" class="form-control" cols="">{{ old('note') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section" id="order-review-wp">
                    <div class="section-head">
                        <h1 class="section-title">Thông tin đơn hàng</h1>
                    </div>
                    <div class="section-detail">
                        <table class="shop-table">
                            <thead>
                                <tr>
                                    <td>Sản phẩm</td>
                                    <td>Tổng</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (Cart::content() as $row)
                                    <tr class="cart-item">
                                        <td class="product-name">{{ $row->name }}<strong
                                                class="product-quantity text-danger">x {{ $row->qty }}</strong>
                                        </td>
                                        <td class="product-total">{{ number_format($row->price, 0, ',', '.') }}đ</td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <tfoot>
                                <tr class="order-total">
                                    <td>Tổng đơn hàng:</td>
                                    <td><strong class="total-price">{{ Cart::subtotal() }}đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div id="payment-checkout-wp">
                            <ul id="payment_methods">
                                <li>
                                    <input type="radio" id="direct-payment" name="payment-method"
                                        value="direct-payment">
                                    <label for="direct-payment">Thanh toán tại cửa hàng</label>
                                </li>
                                <li>
                                    <input type="radio" id="payment-home" name="payment-method" checked
                                        value="payment-home">
                                    <label for="payment-home">Thanh toán tại nhà</label>
                                </li>
                            </ul>
                        </div>
                        <div class="place-order-wp clearfix">
                            <input type="submit" id="order-now" value="Đặt hàng">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#province').on('change', function() {
                var province_id = $(this).val();

                // var selectedText = $('#province option:selected').text();   // Lấy text của option đang đc chọn
                // alert(selectedText);

                var data = {
                    province_id: province_id
                };
                $.ajax({
                    url: '{{ route('handle_ajax_district') }}',
                    method: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        $('#district').empty(); // gắn district empty
                        $.each(data, function(i, district) { // Duyệt district
                            $('#district').append($(
                                '<option>', { // Nối thêm option cho #district
                                    value: district.id,
                                    text: district.name,
                                }));
                        });

                        $('#commune').empty();

                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
                // XỬ LÝ XÃ PHƯỜNG
                $('#district').on('change', function() {
                    var district_id = $(this).val();
                    if (district_id) {
                        $.ajax({
                            url: '{{ route('handle_ajax_wards') }}',
                            method: 'POST',
                            data: {
                                district_id: district_id
                            },
                            dataType: 'json',
                            success: function(data) {
                                // console.log(data);
                                $('#commune').empty();
                                $.each(data, function(i, wards) { // Duyệt wards
                                    $('#commune').append($(
                                        '<option>', { // Nối thêm option cho #wards (xã, phường)
                                            value: wards.id,
                                            text: wards.name,
                                        }));
                                });

                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status);
                                alert(thrownError);
                            }
                        });
                    } else
                        $('#commune').empty();
                });
            })

        })
    </script>
@endsection
