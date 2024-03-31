@extends('layouts.admin')

@section('content')
    <div id="warpper-detail-order">
        <div class="row ">
            <div class="col-12">
                <h1 class="section-title text-center border-bottom py-2">Thông tin đơn hàng</h1>
            </div>
        </div>
        @if (session('ok'))
            <div class="alert alert-success text-center">{{ session('ok') }}</div>
        @endif
        <div class="contener ml-5 mt-3">
            <ul class="detail-order">
                <li>
                    <span class="bold mr-3">Tên khách hàng:</span> {{$detail_info->client}}
                </li>
                <li>
                    <span class="bold mr-3">Số điện thoại:</span> {{$detail_info->phone}}
                </li>
                <li>
                    <span class="bold mr-3">Địa chỉ:</span> {{$detail_info->address}}
                </li>
                <li>
                    <span class="bold mr-3">Email:</span> {{$detail_info->email}}
                </li>
                <li>
                    <form action="{{route('update.status.order')}}" method="POST">
                        @csrf
                        <label for="status" class="bold">Trạng thái đơn hàng: </label>
                        <select name="status" id="status"  class="btn btn-info">
                            <option value="0" {{$status == '0'? 'selected': ''}}>Chờ xử lý</option>
                            <option value="1" {{$status == '1'? 'selected': ''}}>Giao hàng</option>
                            <option value="2" {{$status == '2'? 'selected': ''}}>Thành công</option>
                            <option value="3" {{$status == '3'? 'selected': ''}}>Đã huỷ</option>
                        </select>
                        <input type="hidden" name="id" value="{{$id}}">
                        <button type="submit" class="btn btn-primary">Cập nhật trạng thái</button>
                    </form>
                </li>
                <li class="mb-3">
                    <span class="bold">Sản phẩm:</span> 
                        <table class="shop-table border-bottom">
                            <thead>
                                <tr class="detail-order">
                                    <th>Ảnh</th>
                                    <th>Sản phẩm</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detail_order as $row)
                                    <tr class="cart-item">
                                        <td class="pl-1 pr-1"><img style="width:120px; height:auto" src="{{ url($row->options->file)}}" alt=""></td>
                                        <td class="product-name pl-1 pr-1">{{ $row->name }} <strong
                                                class="product-quantity text-danger pl-3 pr-5"> x {{ $row->qty }}</strong></td>
                                        <td class="product-total pl-1 pr-1">{{ number_format($row->price, 0, ',', '.') }} đ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                </li>
                <li>
                    <span class="bold">Số lượng:</span> {{$detail_info->quantity}} sản phẩm
                </li>
                <li>
                    <span class="bold">Tổng giá tiền:</span> <strong>{{$detail_info->total_price}} Đ</strong>
                </li>
            </ul>
        </div>
    </div>
@endsection
