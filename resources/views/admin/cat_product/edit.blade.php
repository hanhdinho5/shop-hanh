@extends('layouts.admin')

@section('content')
    <div id="content" class="container-fluid">
        <div class="row">
            <div class="col-10">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Chỉnh sửa danh mục
                    </div>
                    <div class="card-body">
                        <form action="{{ route('product.cat.update', $cat_product->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Tên danh mục</label>
                                <input class="form-control" type="text" name="name" id="name"
                                    value="{{ $cat_product->name }}">
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Danh mục cha</label>
                                <select class="form-control" id="" name="parent">
                                    <option value="0">-- Là danh mục cha --</option>
                                    @foreach ($result as $item)
                                        <option {{ $cat_product->parent_id == $item->id ? 'selected' : '' }}
                                            value="{{ $item->id }}">
                                            {{ str_repeat('|---', $item['level']) . $item['name'] }}</option>
                                    @endforeach
                                </select>
                                @error('parent')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="">Trạng thái</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                        value="0" {{ $cat_product->status == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Chờ duyệt
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                        value="1" {{ $cat_product->status == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="exampleRadios2">
                                        Công khai
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
