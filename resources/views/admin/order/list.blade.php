@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            @if (session('no'))
                <div class="alert alert-danger">{{ session('no') }}</div>
            @endif
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Danh sách đơn hàng</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-1" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm khách hàng">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Đang kích
                        hoạt<span class="text-muted">({{ $count[4] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[5] }})</span></a>
                    <br>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 0]) }}" class="text-primary">Chờ xử lý
                        <span class="text-muted">({{ $count[0] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 1]) }}" class="text-primary">Đang giao
                        <span class="text-muted">({{ $count[1] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 2]) }}" class="text-primary">Hoàn thành
                        <span class="text-muted">({{ $count[2] }})</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 3]) }}" class="text-primary">Đã huỷ
                        <span class="text-muted">({{ $count[3] }})</span></a>
                    <a href="">Tổng doanh thu:<span class="text-muted">
                            ({{ number_format($total_revenue, 0, ',', '.') }}đ)</span></a>
                </div>
                <form action="{{ route('order.action') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control wp-act mr-1" name="act" id="">
                            <option value="">Chọn</option>
                            @foreach ($list_act as $k => $item)
                                <option value="{{ $k }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="checkall">
                                </th>
                                <th scope="col">#</th>
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
                        @if ($orders->count() > 0)
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($orders as $item)
                                    @php
                                        $t++;
                                    @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="list_check[]" value="{{ $item->id }}">
                                        </td>
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
                                                    class="btn btn-success btn-sm rounded-0 text-white"
                                                    onclick="return confirm('Bạn có chắc chắn muốn chỉnh sửa đơn hàng')"
                                                    type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i>
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
                                <td colspan="10" class="bg-white">Không tồn tại đơn hàng nào</td>
                            </tr>
                        @endif
                    </table>
                </form>
                {{ $orders->links() }}
                {{-- <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">Trước</span>
                            <span class="sr-only">Sau</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav> --}}
            </div>
        </div>
    </div>
@endsection
