<!DOCTYPE html>
<head>
    <title>Xác nhận đơn hàng</title>
</head>
<body>
    <div
        style="width: 80%;margin: 0 auto;padding: 20px;background-color: #ffffff;
                    border-radius: 5px;box-shadow: 0px 0px 5px #cccccc;box-sizing: ;">
        <h1 style="font-size: 24px;font-weight: bold;margin: 0 0 20px;text-align: center;">Bạn vừa đặt hàng thành công !
        </h1>
        <p>Cảm ơn quý khách đã đặt hàng tại cửa hàng <a href="/">ONLINE EMPORIUM</a> của chúng tôi. Đơn hàng của
            quý khách đã được xác nhận thành công.
            Dưới đây là thông tin chi tiết của đơn hàng của quý khách:</p><br>
        <ul style="margin: 0 10px;padding: 0;list-style: none;">
            <li>
                <strong style="margin-right: 20px;">Tên khách hàng:</strong> {{$client}}
            </li>
            <li>
                <strong style="margin-right: 37px;">Số điện thoại: </strong> {{$phone}}
            </li>
            <li>
                <strong style="margin-right: 78px;">Địa chỉ:</strong> {{$address}}
            </li>
            <li>
                <strong style="margin-right: 86px;">Email:</strong> {{$email}}
            </li>
            <li>
                <strong>Sản phẩm:</strong>
                <table
                    style="width: 80%;text-align: left;border-collapse: collapse;margin-bottom: 20px; border: 1px solid rebeccapurple">
                    <thead>
                        <tr>
                            <th style="padding: 8px;border-bottom: 1px solid #ddd;">#</th>
                            <th style="padding: 8px;border-bottom: 1px solid #ddd;">Tên sản phẩm</th>
                            <th style="padding: 8px;border-bottom: 1px solid #ddd;">Tổng giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $t = 0; ?>
                        @foreach (Cart::content() as $row)
                            <tr>
                                <td style="padding: 8px;border-bottom: 1px solid #ddd;">{{++$t}}</td>
                                <td style="padding: 8px;border-bottom: 1px solid #ddd;">{{ $row->name }} <strong
                                        style="color: red; margin-left:2em">x {{ $row->qty }}</strong></td>
                                <td style="padding: 8px;border-bottom: 1px solid #ddd;">
                                    {{ number_format($row->price, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </li>
            <li>
                <strong style="margin-right: 30px;">Tổng số lượng:</strong> {{$quantity}} sản phẩm
            </li>
            <li>
                <strong style="margin-right: 40px;">Tổng giá tiền:</strong> <strong>{{Cart::subtotal()}} Đ</strong>
            </li>
        </ul>
        <a href="#"
            style="display: inline-block;background-color: #007bff;color: #ffffff;font-size: 16px;line-height: 1.5;text-align: center;text-decoration: none;
                    padding: 10px 20px;border-radius: 5px; margin: 20px 0 20px 0;">Theo dõi đơn hàng</a>
        <p style="text-align: center">Xin vui lòng giữ cho thông tin đơn hàng của quý khách được bảo mật và không chia sẻ với bất kỳ ai khác.</p>
        <div style="text-align: center">
            <p>Email này được gửi tự động. Vui lòng không trả lời.</p>
            <p>
                &copy; 2021 Cửa hàng Online Emporium &bull; 123 Main Street, New York, NY 10001 &bull; <a
                    href="#">
                    www.example.com</a>
            </p>
        </div>
    </div>
</body>

</html>




{{-- 

                <span class="bold">Số lượng:</span> {{$quantity}}
            </li>
            <li>
                <span class="bold">Tổng giá tiền:</span> <strong></strong>
            </li> --}}
