@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Điện thoại</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <div class="thumb-wp fl-left">
                        <a style="width: 400px;" id="main-thumb">
                            <img id="zoom" src="{{url($product_detail->img)}}"/>
                        </a>
                        <script>
                            var options = {
                                width: 500,
                                zoomWidth: 300,
                                offset: {vertical: 0, horizontal: -130}
                            };
                            new ImageZoom(document.getElementById("main-thumb"), options);
                             
                        </script>
                        <div id="list-thumb">
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                            <a href="">
                                <img id="zoom" src="{{url($product_detail->img)}}" />
                            </a>
                        </div>
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="public/images/img-pro-01.png" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name">{{$product_detail->name}}</h3>
                        <div class="desc" style="line-height: 7px">
                            {!!$product_detail->detail!!}
                            <p>Chọn màu: </p>
                                <button type="button" class="btn btn-secondary"></button>
                                <button type="button" class="btn btn-success"></button>
                                <button type="button" class="btn btn-danger"></button>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status">Còn hàng</span>
                        </div>
                        <p class="price">{{number_format($product_detail->price, 0, ',', '.')}}Đ</p>
                        <form action="{{route('cart.add', $product_detail->id) }}" method="post">
                            @csrf
                            <div id="num-order-wp">
                                <a title="" id="minus"><i class="fa fa-minus"></i></a>
                                <input type="text" class="qty_detail_product" name="num-order" value="1" id="num-order" >
                                <a title="" id="plus"><i class="fa fa-plus"></i></a>
                                {{-- <input type="number" value="1" min="1" max="10"> --}}
                            </div>
                            <button data-id="{{$product_detail->id}}" type="submit" class="btn btn-success add_product">Thêm giỏ hàng</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    {!! $product_detail->des!!}
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @forelse ($list_together_cat_product as $item)
                        <li>
                            <a href="{{route('product.detail', [$item->slug, $item->id])}}" title="" class="thumb">
                                <img src="{{url($item->img)}}" class="zoom">
                            </a>
                            <a href="" title="" class="product-name">{{$item->name}}</a>
                            <div class="price">
                                <span class="new">{{number_format($item->price, 0, ',', '.')}}đ</span>
                                <span class="old">20.900.000đ</span>
                            </div>
                            <div class="action clearfix">
                                <a href="" data-id="{{$item->id}}" title="" class="add-cart text-center add_product p-2">Thêm giỏ hàng</a>
                                <!--<a href="" title="" class="buy-now fl-right">Mua ngay</a>-->
                            </div>
                        </li>
                        @empty
                            <p class="text-danger">Không tồn tại sản phẩm nào cùng chuyên mục</p>
                        @endforelse
                    </ul>
                    {{$list_together_cat_product->links()}}
                </div>
            </div>
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
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="" title="" class="thumb">
                        <img src="{{asset('client.css/images/banner.png')}}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection