<!DOCTYPE html>
<html>

<head>
    <title>OnlineEmporium</title>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('client.css/css/bootstrap/bootstrap-theme.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/css/bootstrap/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/reset.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/css/carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/css/carousel/owl.theme.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/css/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('client.css/responsive.css') }}" rel="stylesheet" type="text/css" />

    <script src="{{ asset('client.css/js/jquery-2.2.4.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client.css/js/elevatezoom-master/jquery.elevatezoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client.css/js/bootstrap/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client.css/js/carousel/owl.carousel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('client.css/js/main.js') }}" type="text/javascript"></script>

    <script src="https://unpkg.com/js-image-zoom@0.4.1/js-image-zoom.js" type="application/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>

<body>
    <div id="site">
        <div id="container">
            <div id="header-wp">
                <div id="head-top" class="clearfix">
                    <div class="wp-inner">
                        <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                        <div id="main-menu-wp" class="fl-right">
                            <ul id="main-menu" class="clearfix">
                                <li>
                                    <a href="{{ url('/') }}" title="">Trang chủ</a>
                                </li>
                                <li>
                                    <a href="{{ route('product.show') }}" title="">Sản phẩm</a>
                                </li>
                                <li>
                                    <a href="{{ url('bai-viet') }}" title="">Blog</a>
                                </li>
                                <li>
                                    <a href="{{ url('trang/gioi-thieu') }}" title="">Giới thiệu</a>
                                </li>
                                <li>
                                    <a href="{{ url('trang/lien-he') }}" title="">Liên hệ</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="head-body" class="clearfix">
                    <div class="wp-inner">
                        <a href="{{ route('client.home') }}" title="" id="logo" class="fl-left"><img
                                style="height:66px; width:auto; filter: brightness(220%)" src="{{ asset('client.css/images/logo.png') }}" /></a>
                        <div id="search-wp" class="fl-left">
                            <form method="POST" action="{{ route('product.show.seach') }}">
                                @csrf
                                <input type="text" name="keyword" id="s" value="{{ request()->keyword }}"
                                    placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                <button type="submit" id="sm-s" class="padding">Tìm kiếm</button>
                            </form>
                            <ul id="seach" class="bg-white">
                                {{-- <li class="d-flex border-bottom">
                                    <a href=""><img src="{{ asset('upload/product/img-pro-02.png') }}"
                                            alt=""></a>
                                    <a href="">
                                        <h4>title product 1</h4>
                                    </a>
                                </li>
                                <li class="d-flex border-bottom">
                                    <a href=""><img src="{{ asset('upload/product/img-pro-02.png') }}"
                                            alt=""></a>
                                    <a href="">
                                        <h4>title product 2</h4>
                                    </a>
                                </li>
                                <li class="d-flex border-bottom">
                                    <a href=""><img src="{{ asset('upload/product/img-pro-02.png') }}"
                                            alt=""></a>
                                    <a href="">
                                        <h4>title product 3</h4>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                        <div id="action-wp" class="fl-right">
                            <a href="{{ route('contact') }}" id="advisory-wp" class="fl-left text-white">
                                <span class="title">Tư vấn</span>
                                <span class="phone">0397.274.214</span>
                                <a>
                                    <div id="btn-respon" class="fl-right"><i class="fa fa-bars"
                                            aria-hidden="true"></i>
                                    </div>
                                    <a href="?page=cart" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span id="num">2</span>
                                    </a>
                                    <div id="cart-wp" class="fl-right">
                                        <a href="{{ route('cart.show') }}" id="btn-cart" class="text-white">
                                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                            <span id="num">{{ Cart::count() }}</span>
                                        </a>
                                        <div id="dropdown">
                                            <p class="desc">Có <span id="total-title">{{ Cart::count() }} sản
                                                    phẩm</span>
                                                trong giỏ hàng</p>
                                            <div class="total-price clearfix">
                                                <p class="title fl-left">Tổng:</p>
                                                <p class="price fl-right">{{ Cart::subtotal() }}đ</p>
                                            </div>
                                            <div class="action-cart clearfix">
                                                <a href="{{ route('cart.show') }}" title="Giỏ hàng"
                                                    class="view-cart fl-left">Giỏ hàng</a>
                                                <a href="{{ route('checkout') }}" title="Thanh toán"
                                                    class="checkout fl-right">Thanh
                                                    toán</a>
                                            </div>
                                        </div>
                                    </div>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')

            <div id="footer-wp">
                <div id="foot-body">
                    <div class="wp-inner clearfix">
                        <div class="block" id="info-company">
                            <h3 class="title">ONLINE EMPORIUM</h3>
                            <p class="desc">ONLINE EMPORIUM luôn cung cấp luôn là sản phẩm chính hãng có thông tin rõ
                                ràng,
                                chính sách ưu đãi cực lớn cho khách hàng có thẻ thành viên.</p>
                            <div id="payment">
                                <div class="thumb">
                                    <img src="public/images/img-foot.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="block menu-ft" id="info-shop">
                            <h3 class="title">Thông tin cửa hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <p>106 - Trần Bình - Cầu Giấy - Hà Nội</p>
                                </li>
                                <li>
                                    <p>0987.654.321 - 0989.989.989</p>
                                </li>
                                <li>
                                    <p>vshop@gmail.com</p>
                                </li>
                            </ul>
                        </div>
                        <div class="block menu-ft policy" id="info-shop">
                            <h3 class="title">Chính sách mua hàng</h3>
                            <ul class="list-item">
                                <li>
                                    <a href="" title="">Quy định - chính sách</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách bảo hành - đổi trả</a>
                                </li>
                                <li>
                                    <a href="" title="">Chính sách hội viện</a>
                                </li>
                                <li>
                                    <a href="" title="">Giao hàng - lắp đặt</a>
                                </li>
                            </ul>
                        </div>
                        <div class="block" id="newfeed">
                            <h3 class="title">Bảng tin</h3>
                            <p class="desc">Đăng ký với chung tôi để nhận được thông tin ưu đãi sớm nhất</p>
                            <div id="form-reg">
                                <form method="POST" action="">
                                    <input type="email" name="email" id="email"
                                        placeholder="Nhập email tại đây">
                                    <button type="submit" id="sm-reg">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="foot-bot">
                    <div class="wp-inner">
                        <p id="copyright">© Bản quyền thuộc về olineemporium.com | Php Master Laravel</p>
                    </div>
                </div>
            </div>
        </div>
        <div id="menu-respon">
            <a href="?page=home" title="" class="logo">VSHOP</a>
            <div id="menu-respon-wp">
                <ul class="" id="main-menu-respon">
                    <li>
                        <a href="?page=home" title>Trang chủ</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>Điện thoại</a>
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
                                </ul>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Nokia</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=category_product" title>Máy tính bảng</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>Laptop</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title>Đồ dùng sinh hoạt</a>
                    </li>
                    <li>
                        <a href="?page=blog" title>Blog</a>
                    </li>
                    <li>
                        <a href="#" title>Liên hệ</a>
                    </li>
                </ul>
            </div>
        </div>
        <div id="btn-top"><img src="{{ asset('client.css/images/img-to-top.png') }}" alt="" /></div>
        <div id="fb-root"></div>
        <script>
            (function(d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {
                $(".num-order").change(function() {
                    var rowId = $(this).attr('data-rowId');
                    var qty = $(this).val();
                    var price = $(this).attr('data-price');
                    var data = {
                        rowId: rowId,
                        qty: qty,
                        price: price,
                    };
                    $.ajax({
                        url: "{{ route('cart.update') }}",
                        method: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(data) {
                            $('#subtotal' + data.rowId).text(data.subtotal + 'đ');
                            $('span#total_many').text(data.total + 'đ');
                            $('span#num').text(data.count);
                            $('span#total-title').text(data.count);
                            $('p.price').text(data.total + 'đ');

                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                });

                // Add 1 product enter cart
                $('.add_product').click(function() {
                    // Xử lý ajax thêm vào cart
                    var id_product = $(this).attr('data-id');
                    var qty = $('input.qty_detail_product').val();
                    // alert(qty);
                    var data = {
                        id_product: id_product,
                        qty: qty
                    };
                    $.ajax({
                        url: "{{ route('cart.add.ajax') }}",
                        method: 'POST',
                        data: data,
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            $('span#total-title').text(data.count);
                            $('span#num').text(data.count);
                            $('p.price').text(data.total + 'đ');
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                    // Xử lý thông báo
                    Swal.fire({
                        icon: 'success',
                        title: 'Thêm sản phẩm thành công!<br>',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    // Swal.fire({
                    //     title: '<span style="font-size:20px;">Đã thêm sản phẩm vào giỏ hàng!</span>',
                    //     icon: "success",
                    //     showCancelButton: true,
                    //     focusConfirm: false,
                    // })
                    return false;
                });

                // Lọc theo giá
                $("td input.r_price").click(function() {
                    $("button.filter").click();
                });

                // Xử lý ajax seach show product
                $('input#s').keyup(function() {   // khi nhấm bàn phím
                    // alert('Bạn vừa nhấn bàn phím');
                    var keyword = $(this).val();
                    $.ajax({
                        url: "{{ route('seach.product.ajax') }}",
                        method: 'POST',
                        data: {keyword : keyword},
                        dataType: 'json',
                        success: function(data) {
                            // console.log(data);
                            $('#seach').html(data.str);
                           
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                });






            });
        </script>
</body>

</html>
