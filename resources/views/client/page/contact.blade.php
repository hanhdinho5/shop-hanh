@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="clearfix detail-blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Liên hệ</h3>
                </div>
                <div class="section-detail">
                    <span class="create-date">20/07/2023</span>
                    <div class="detail">
                        <h5>Liên hệ với chúng tôi!</h5>
                        <img src="{{asset('upload/pages/lien-he.jpg')}}" alt="">
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti, est quia?
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                        </p>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti, est quia?
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti, est quia?
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                            Dolore nostrum est
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti, est quia?
                            Dolore nostrum est similique quae sapiente doloremque eveniet aut non, vero placeat ea excepturi voluptates repudiandae sunt, impedit soluta. Deleniti
                            Dolore nostrum est
                        </p>
                    </div>
                </div>
            </div>
            <div class="section" id="social-wp">
                <div class="section-detail">
                    <div class="fb-like" data-href="" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                    <div class="g-plusone-wp">
                        <div class="g-plusone" data-size="medium"></div>
                    </div>
                    <div class="fb-comments" id="fb-comment" data-href="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @forelse ($bestsellingProducts as $bestsellingProduct)
                            <li class="clearfix">
                                <a href="{{route('product.detail', [$bestsellingProduct->slug, $bestsellingProduct->id])}}" title="" class="thumb fl-left">
                                    <img src="{{ url($bestsellingProduct->img) }}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="?page=detail_product" title=""
                                        class="product-name">{{ $bestsellingProduct->name }}</a>
                                    <div class="price">
                                        <span
                                            class="new">{{ number_format($bestsellingProduct->price, 0, ',', '.') }}đ</span>
                                    </div>
                                    <a href="{{route('product.detail',[$bestsellingProduct->slug, $bestsellingProduct->id])}}" title="" class="buy-now">Xem chi tiết</a>
                                </div>
                            </li>
                        @empty
                            <p class="text-danger">Không tồn tại trang</p>
                        @endforelse

                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection