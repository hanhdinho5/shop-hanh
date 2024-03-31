@extends('layouts.client')
@section('content')
    <div id="main-content-wp" class="home-page clearfix">
        <div class="wp-inner">
            <div class="main-content fl-right">
                <div class="section" id="slider-wp">
                    <div class="section-detail">
                        <div class="item">
                            <img src="{{ asset('client.css/images/slider-01.png') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('client.css/images/slider-02.png') }}" alt="">
                        </div>
                        <div class="item">
                            <img src="{{ asset('client.css/images/slider-03.png') }}" alt="">
                        </div>
                    </div>
                </div>
                <div class="section" id="support-wp">
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('client.css/images/icon-1.png') }}">
                                </div>
                                <h3 class="title">Miễn phí vận chuyển</h3>
                                <p class="desc">Tới tận tay khách hàng</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('client.css/images/icon-2.png') }}">
                                </div>
                                <h3 class="title">Tư vấn 24/7</h3>
                                <p class="desc">1900.9999</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('client.css/images/icon-3.png') }}">
                                </div>
                                <h3 class="title">Tiết kiệm hơn</h3>
                                <p class="desc">Với nhiều ưu đãi cực lớn</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('client.css/images/icon-4.png') }}">
                                </div>
                                <h3 class="title">Thanh toán nhanh</h3>
                                <p class="desc">Hỗ trợ nhiều hình thức</p>
                            </li>
                            <li>
                                <div class="thumb">
                                    <img src="{{ asset('client.css/images/icon-4.png') }}">
                                </div>
                                <h3 class="title">Đặt hàng online</h3>
                                <p class="desc">Thao tác đơn giản</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="section" id="feature-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm nổi bật</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @forelse ($featuredProducts as $featuredProduct)
                                <li>
                                    <a href="{{ route('product.detail', [$featuredProduct->slug, $featuredProduct->id]) }}"
                                        title="" class="thumb">
                                        <img src="{{ url($featuredProduct->img) }}" class="zoom">
                                    </a>
                                    <a href="?page=detail_product" title=""
                                        class="product-name">{{ $featuredProduct->name }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($featuredProduct->price, 0, ',', '.') }}đ</span>
                                        <span class="old">22.190.000đ</span>
                                    </div>
                                    <div class="action clearfix">
                                        <a href="" data-id="{{ $featuredProduct->id }}"
                                            class="add-cart text-center add_product p-2">Thêm giỏ hàng</a>
                                        <!--<a href="{{ route('checkout_fast', $featuredProduct->id) }}" title=""-->
                                        <!--    class="buy-now fl-right">Mua ngay</a>-->
                                    </div>
                                </li>
                            @empty
                                <p class="text-danger">Không có sản phẩm nổi bậc nào</p>
                            @endforelse

                        </ul>
                    </div>
                </div>
                @forelse ($list_cat_pr0 as $item_cat)
                    @if ($item_cat->products->count() > 0)
                        <div class="section" id="list-product-wp">
                            <div class="section-head">
                                <h3 class="section-title">{{ $item_cat->name }}</h3>
                            </div>
                            <div class="section-detail">
                                <ul class="list-item clearfix flex-product">
                                    @foreach ($item_cat->products as $product)
                                        <li>
                                            <a href="{{ route('product.detail', [$product->slug, $product->id]) }}"
                                                title="" class="thumb">
                                                <img src="{{ url($product->img) }}" class="zoom">
                                            </a>
                                            <a href="?page=detail_product" title=""
                                                class="product-name">{{ $product->name }}</a>
                                            <div class="price">
                                                <span
                                                    class="new">{{ number_format($product->price, 0, ',', '.') }}đ</span>
                                                <span class="old">21.990.000đ</span>
                                            </div>
                                            <div class="action clearfix">
                                                <a href="" data-id="{{ $product->id }}"
                                                    class="add-cart text-center add_product p-2">Thêm giỏ hàng</a>
                                                <!--<a href="{{ route('checkout_fast', $product->id) }}" title="Mua ngay"-->
                                                <!--    class="buy-now fl-right">Mua ngay</a>-->
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                @empty
                    <p class="text-danger">Không tồn tại danh mục và sản phẩm nào</p>
                @endforelse

            </div>
            <div class="sidebar fl-left">
                <div class="section" id="category-product-wp">
                    <div class="section-head">
                        <h3 class="section-title">Danh mục sản phẩm</h3>
                    </div>
                    <div class="secion-detail">
                        {!! $menu !!}
                        {{-- <ul class="list-item">
                            @foreach ($list_cat_pr0 as $item)
                                <li>
                                    <a href="{{route('product.cat', [$item->slug, $item->id])}}" title="">{{$item->name}}</a>
                                </li>
                            @endforeach
                            <li>
                                <a href="?page=category_product" title="">Danh mục 1 (ĐT)</a>
                                <ul class="sub-menu">
                                    <li>
                                        <a href="?page=category_product" title="">Iphone</a>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Samsung</a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="?page=category_product" title="">Iphone X</a>
                                            </li>
                                            <li>
                                                <a href="?page=category_product" title="">Iphone 8</a>
                                            </li>
                                            <li>
                                                <a href="?page=category_product" title="">Iphone 8 Plus</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Oppo</a>
                                    </li>
                                    <li>
                                        <a href="?page=category_product" title="">Bphone</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Tai nghe</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Thời trang</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Đồ gia dụng</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Thiết bị văn phòng</a>
                            </li>
                        </ul> --}}
                    </div>
                </div>
                <div class="section" id="selling-wp">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm bán chạy</h3>
                    </div>
                    <div class="section-detail">
                        <ul class="list-item">
                            @forelse ($bestsellingProducts as $bestsellingProduct)
                                <li class="clearfix">
                                    <a href="{{ route('product.detail', [$bestsellingProduct->slug, $bestsellingProduct->id]) }}"
                                        title="" class="thumb fl-left">
                                        <img src="{{ url($bestsellingProduct->img) }}" alt="">
                                    </a>
                                    <div class="info fl-right">
                                        <a href="?page=detail_product" title=""
                                            class="product-name">{{ $bestsellingProduct->name }}</a>
                                        <div class="price">
                                            <span
                                                class="new">{{ number_format($bestsellingProduct->price, 0, ',', '.') }}đ</span>
                                        </div>
                                        <a href="{{ route('checkout_fast', $bestsellingProduct->id) }}" title=""
                                            class="buy-now">Mua ngay</a>
                                    </div>
                                </li>
                            @empty
                                <p class="text-danger">Không tồn tại sản phẩm bán chạy nào</p>
                            @endforelse

                        </ul>
                    </div>
                </div>
                <div class="section" id="banner-wp">
                    <div class="section-detail">
                        <a href="" title="" class="thumb">
                            <img src="{{ asset('client.css/images/banner.png') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
