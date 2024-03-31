@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        @if (session('ok'))
            <div class="alert alert-success">{{ session('ok') }}</div>
        @endif
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Chỉnh sửa thông tin quyền
                    </div>
                    <div class="card-body">
                        {!! Form::open(['route' => ['permission.update', $permission->id] ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', 'Tên quyền') !!}
                            {!! Form::text('name', $permission->name, ['class' => 'form-control', 'id' => 'name']) !!}
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('slug', 'Slug') !!}
                            <small class="form-text text-muted pb-2">Ví dụ: post.add</small>
                            {!! Form::text('slug', $permission->slug, ['class' => 'form-control', 'id' => 'slug']) !!}
                            @error('slug')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            {!! Form::label('des', 'Mô tả') !!}
                            {!! Form::textarea('des', $permission->description, ['class' => 'form-control', 'id' => 'des', 'rows' => 5]) !!}
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        Danh sách quyền
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tên quyền</th>
                                    <th scope="col">Slug</th>
                                    <th scope="col">Tác vụ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $t = 0;
                                @endphp
                                @foreach ($permissions as $moduleName => $modulePermission)
                                    <tr>
                                        <td scope="row"></td>
                                        <td><strong>Module {{ ucfirst($moduleName) }}</strong></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @foreach ($modulePermission as $permission)
                                        <tr>
                                            <td scope="row">{{ ++$t }}</td>
                                            <td>|---{{ $permission->name }}</td>
                                            <td>{{ $permission->slug }}</td>
                                            <td><a href="{{ route('permission.edit', $permission->id) }}"><button
                                                        class="btn btn-success btn-sm rounded-0" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                            class="fa fa-edit"></i></button></a>
                                                <a href="{{ route('permission.delete', $permission->id) }}"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xoá quyền {{$permission->name}} không?')"><button
                                                        class="btn btn-danger btn-sm rounded-0" type="button"
                                                        data-toggle="tooltip" data-placement="top" title="Delete"><i
                                                            class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
