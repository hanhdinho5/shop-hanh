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
                <h5 class="m-0 ">Danh sách trang</h5>
                <div class="form-search form-inline">
                    <form action="" class="d-flex">
                        <input type="" class="form-control form-search mr-3" name="keyword"
                            value="{{ request()->input('keyword') }}" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div class="analytic">
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Công khai<span
                            class="text-muted">({{ $count[0] }})</span></a>
                    <a href="" class="text-primary">Chờ duyệt<span class="text-muted">(0)</span></a>
                    <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Thùng rác<span
                            class="text-muted">({{ $count[1] }})</span></a>
                </div>
                <form action="{{ route('active') }}" method="POST">
                    @csrf
                    <div class="form-action form-inline py-3">
                        <select class="form-control mr-1" name="act" id="">
                            <option>Chọn</option>
                            @foreach ($list_act as $k => $item)
                                <option value="{{ $k }}">{{ $item }}</option>
                            @endforeach
                        </select>
                        <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
                    </div>
                    <table class="table table-striped table-checkall">
                        <thead>
                            <tr>
                                <th scope="col">
                                    <input name="checkall" type="checkbox">
                                </th>
                                <th scope="col">#</th>
                                {{-- <th scope="col">Ảnh</th> --}}
                                <th scope="col">Tiêu đề</th>
                                <th scope="col">Ngày tạo</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($pages->count() > 0)
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($pages as $page)
                                    @php
                                        $t++;
                                    @endphp

                                    <tr>
                                        <td>
                                            <input type="checkbox" name="checkbox[]" value="{{ $page->id }}">
                                        </td>
                                        <td scope="row">{{ $t }}</td>
                                        <td><a href="">{{ $page->title }}</a></td>
                                        <td>{{ $page->created_at }}</td>
                                        <td>
                                            @canany(['page.edit'])
                                                <a href="{{ route('page.edit', $page->id) }}"
                                                    class="btn btn-success btn-sm rounded-0" type="button"
                                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                        class="fa fa-edit"></i>
                                                </a>
                                            @endcanany
                                            @canany(['page.delete'])
                                                <a href="{{ route('page.delete', $page->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xoá trang này')"
                                                    class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                                    data-placement="top" title="Delete"><i class="fa fa-trash"></i>
                                                </a>
                                            @endcanany
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="bg-white">Không tồn tại trang nào</td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                    {{ $pages->links() }}
                </form>
            </div>
        </div>
    </div>
@endsection