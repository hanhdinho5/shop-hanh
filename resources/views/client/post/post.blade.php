@extends('layouts.client')
@section('content')
<div id="main-content-wp" class="clearfix blog-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">Blog</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-blog-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title">Blog</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @forelse ($posts as $post)
                            <li class="clearfix">
                                <a href="{{route('post.detail', [Str::slug($post->name), $post->id])}}" title="" class="thumb fl-left">
                                    <img src="{{url($post->img)}}" alt="">
                                </a>
                                <div class="info fl-right">
                                    <a href="{{route('post.detail', [Str::slug($post->name), $post->id])}}" title="" class="title">{{$post->name}}</a>
                                    <span class="create-date">{{$post->created_at}}</span>
                                    <p class="desc">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad, odio nisi excepturi eum, nostrum harum similique, perferendis tempore ipsum esse aliquam voluptate beatae non aut facilis deserunt. Dolorum, tenetur quos!</p>
                                </div>
                            </li>
                        @empty
                            <p class="text-danger">Không tồn tại bài viết nào</p>
                        @endforelse
                        
                    </ul>
                </div>
            </div>
            {{$posts->links()}}
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
            <div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        @forelse ($bestsellingProducts as $bestsellingProduct)
                            <li class="clearfix">
                                <a href="{{route('product.detail',[$bestsellingProduct->slug, $bestsellingProduct->id])}}" title="" class="thumb fl-left">
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
                            <p class="text-danger">Không tồn tại sản phẩm bán chạy nào</p>
                        @endforelse

                    </ul>
                </div>
            </div>
            <div class="section" id="banner-wp">
                <div class="section-detail">
                    <a href="?page=detail_blog_product" title="" class="thumb">
                        <img src="public/images/banner.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection