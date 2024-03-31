@extends('layouts.admin')

@section('content')
    <div class="container-fluid py-5">
        <div class="row">
            <div class="col">
                <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐANG XỬ LÝ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[0] }}</h5>
                        <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[1] }}</h5>
                        <p class="card-text">Đơn hàng giao dịch thành công</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                    <div class="card-header">DOANH SỐ</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ number_format($total_revenue, 0, ',', '.') }} Đ</h5>
                        <p class="card-text">Doanh số hệ thống</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                    <div class="card-header">ĐƠN HÀNG HỦY</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $count[2] }}</h5>
                        <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- end analytic  -->
        <div class="card">
            <div class="card-header font-weight-bold">
                ĐƠN HÀNG MỚI
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th scope="col">Mã</th>
                            <th scope="col">Khách hàng</th>
                            <th scope="col">Email</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá trị đơn hàng</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Thời gian</th>
                            <th scope="col">Tác vụ</th>
                        </tr>
                    </thead>
                    @if ($orders_new->count() > 0)
                        <tbody>
                            @php
                                $t = 0;
                            @endphp
                            @foreach ($orders_new as $item)
                                @php
                                    $t++;
                                @endphp
                                <tr>
                                    <td>{{ $t }}</td>
                                    <td><a href="{{ route('order.detail', $item->id) }}">{{ $item->code }}</a></td>
                                    <td>
                                        {{ $item->client }}<br>
                                        {{ $item->phone }}
                                    </td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->total_price }} đ</td>
                                    @if ($item->status == 0)
                                        <td><span class="badge badge-warning">Chờ xử lý</span></td>
                                    @endif
                                    @if ($item->status == 1)
                                        <td><span class="badge badge-primary">Đang giao</span></td>
                                    @endif
                                    @if ($item->status == 2)
                                        <td><span class="badge badge-success">Hoàn thành</span></td>
                                    @endif
                                    @if ($item->status == 3)
                                        <td><span class="badge badge-danger">Đã huỷ</span></td>
                                    @endif

                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        @canany(['order.edit'])
                                            <a href="{{ route('order.edit', $item->id) }}"
                                                class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        @endcanany
                                        @canany(['order.delete'])
                                            <a href="{{ route('order.delete', $item->id) }}"
                                                onclick="return confirm('Bạn có chắc chắn muốn xoá đơn hàng')"
                                                class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                                data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                    class="fa fa-trash"></i>
                                            </a>
                                        @endcanany
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9"><small>Click vào mã đơn hàng để xem chi tiết đơn hàng!</small></td>
                            </tr>
                        </tfoot>
                    @else
                        <tr>
                            <td colspan="10" class="bg-white">Không tồn tại đơn hàng chờ xử lý nào</td>
                        </tr>
                    @endif
                </table>
                {{ $orders_new->links() }}
            </div>
        </div>

    </div>
@endsection
