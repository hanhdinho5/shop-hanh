@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="clearfix category-product-page">
        <div class="wp-inner">
            <div class="secion" id="breadcrumb-wp">
                <div class="secion-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">Trang chủ</a>
                        </li>
                        <li>
                            <a href="" title="">Sản phẩm</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="main-content fl-right">
                <div class="section" id="list-product-wp">
                    @if ($list_product->count() == 0)
                        <div id="wp-seach-product" class="text-center">
                            <img style="border-radius: 100%;width: 35%;margin: 1em auto;"  src="{{asset('client.css/images/seach_error.jpg')}}" alt="">
                            <strong class="font-italic">Không tìm thấy sản phẩm nào!</strong>
                        </div>
                    @else
                        <div class="section-head clearfix">
                            @if (empty($keyword))
                                <h3 class="section-title fl-left">Danh sách sản phẩm</h3>
                            @else
                                <h6 style="margin: 0">Có <strong>{{ $list_product->count() }}</strong> sản phẩm với từ khoá
                                    " <strong>{{ $keyword }}</strong> "</h6>
                            @endif
                            <div class="filter-wp fl-right text-center">
                                <p class="desc text-center">Hiển thị {{$list_product->count()}} sản phẩm</p>
                                <div class="form-filter">
                                    <form method="POST" action="#">
                                        @csrf
                                        <select name="select">
                                            <option value="0">Sắp xếp</option>
                                            <option value="1">Từ A-Z</option>
                                            <option value="2">Từ Z-A</option>
                                            <option value="3">Giá thấp lên cao</option>
                                            <option value="4">Giá cao xuống thấp</option>
                                        </select>
                                        <input type="hidden" name="r_price" value="{{ request()->r_price }}">
                                        <input type="hidden" name="keyword" value="{{ request()->keyword }}">
                                        <button type="submit">Lọc</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="section-detail">
                            <ul class="list-item clearfix flex-product">
                                @forelse ($list_product as $item)
                                    <li>
                                        <a href="{{ route('product.detail', [$item->slug, $item->id]) }}" title=""
                                            class="thumb">
                                            <img src="{{ url($item->img) }}" class="zoom">
                                        </a>
                                        <a href="" title="" class="product-name">{{ $item->name }}</a>
                                        <div class="price">
                                            <span class="new">{{ number_format($item->price, 0, ',', '.') }}đ</span>
                                            <span class="old">22.900.000đ</span>
                                        </div>
                                        <div class="action clearfix">
                                            <a href="" data-id="{{ $item->id }}"
                                                class="add-cart text-center add_product p-2">Thêm giỏ hàng</a>
                                            {{-- <a href="{{route('cart.add', $item->id)}}" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a> --}}
                                            <!--<a href="{{ route('checkout_fast', $item->id) }}" title="Mua ngay"-->
                                            <!--    class="buy-now fl-right">Mua ngay</a>-->
                                        </div>
                                    </li>
                                @empty
                                    <p class="text-danger">Không tồn tại sản phẩm nào</p>
                                @endforelse
                            </ul>
                        </div>
                        {{ $list_product->links() }}
                    @endif

                </div>
                {{-- <div class="section" id="paging-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <a href="" title="">1</a>
                        </li>
                        <li>
                            <a href="" title="">2</a>
                        </li>
                        <li>
                            <a href="" title="">3</a>
                        </li>
                    </ul>
                </div>
            </div> --}}
            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        {!!$menu!!}
                    </div>
                </div>
                <div class="section" id="filter-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Bộ lọc</h3>
                    </div>
                    <div class="section-detail">
                        <form method="POST" action="">
                            @csrf
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Giá</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" class="r_price" name="r_price"
                                                {{ $pr == '<500' ? 'checked' : '' }} value="<500"></td>
                                        <td>Dưới 500.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" class="r_price" name="r_price"
                                                {{ $pr == '500-1000' ? 'checked' : '' }} value="500-1000"></td>
                                        <td>500.000đ - 1.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" class="r_price" name="r_price"
                                                {{ $pr == '1000-5000' ? 'checked' : '' }} value="1000-5000"></td>
                                        <td>1.000.000đ - 5.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" class="r_price" name="r_price"
                                                {{ $pr == '5000-10000' ? 'checked' : '' }} value="5000-10000"></td>
                                        <td>5.000.000đ - 10.000.000đ</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" class="r_price" name="r_price"
                                                {{ $pr == '>10000' ? 'checked' : 'kkk' }} value=">10000"></td>
                                        <td>Trên 10.000.000đ</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Hãng</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Acer</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Apple</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Hp</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Lenovo</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Samsung</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-brand"></td>
                                        <td>Toshiba</td>
                                    </tr>
                                </tbody>
                            </table>
                            <table>
                                <thead>
                                    <tr>
                                        <td colspan="2">Loại</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="radio" name="r-price"></td>
                                        <td>Điện thoại</td>
                                    </tr>
                                    <tr>
                                        <td><input type="radio" name="r-price"></td>
                                        <td>Laptop</td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="keyword" value="{{ request()->keyword }}">
                            <button type="submit" style="display:none" class="filter">Lọc</button>
                        </form>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="?page=detail_product" title="" class="thumb">
                            <img src="{{ asset('client.css/images/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
