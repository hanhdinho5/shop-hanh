@extends('layouts.admin')
@section('content')
    <div id="content" class="container-fluid">
        <div class="card">
            <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
                <h5 class="m-0 ">Cập nhật vai trò</h5>
                <div class="form-search form-inline">
                    <form action="#" class="d-flex">
                        <input type="" class="form-control form-search mr-1" placeholder="Tìm kiếm">
                        <input type="submit" name="btn-search" value="Tìm kiếm" class="btn btn-primary">
                    </form>
                </div>
            </div>
            <div class="card-body">
                {{-- <form method="POST" action="" enctype="multipart/form-data"> --}}
                {!! Form::open(['route' => ['role.update', $role->id]]) !!}

                <div class="form-group">
                    {{-- <label class="text-strong" for="name">Tên vai trò</label>
                    <input class="form-control" type="text" name="name" id="name"> --}}
                    {!! Form::label('name', 'Tên vai trò', ['class' => 'text-strong']) !!}
                    {!! Form::text('name', $role->name, ['class' => 'form-control', 'id' => 'name']) !!}
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <label class="text-strong" for="description">Mô tả</label>
                    <textarea class="form-control" type="text" name="description" id="description"></textarea> --}}
                    {!! Form::label('description', 'Mô tả', ['class' => 'text-strong']) !!}
                    {!! Form::textarea('description', $role->description, ['class' => 'form-control', 'id' => 'description', 'rows'=>4]) !!}
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <strong>Vai trò này có quyền gì?</strong>
                <small class="form-text text-muted pb-2">Check vào module hoặc các hành động bên dưới để chọn quyền.</small>
                <!-- List Permission  -->
                @forelse ($permissions as $permissionName => $permission)
                    <div class="card my-4 border">
                        <div class="card-header">
                            {{-- <input type="checkbox" class="check-all" name=""  id="{{$permissionName}}">
                            <label for="{{$permissionName}}" class="m-0"> Module {{ucfirst($permissionName)}}</label> --}}
                            {!! Form::checkbox(null, null, null, ['class' => 'check-all', 'id' => $permissionName]) !!}
                            {!! html_entity_decode(
                                Form::label($permissionName, '<strong>' . 'Module ' . $permissionName . '</strong>', ['class' => 'm-0']),
                            ) !!}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($permission as $item)
                                    <div class="col-md-3">
                                        {{-- <input type="checkbox" class="permission" value="2" name="permission_id[]" id="{{$item->slug}}">
                                        <label for="{{$item->slug}}">{{$item->name}}</label> --}}
                                        {!! Form::checkbox('permission_id[]', $item->id, in_array($item->id, $role->permissions->pluck('id')->toArray()), 
                                        ['class' => 'permission', 'id' => $item->slug]) !!}
                                        {!! Form::label($item->slug, $item->name) !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Chưa tồn tại quyền nào trên hệ thống</p>
                @endforelse

                <input type="submit" name="btn-add" class="btn btn-primary" value="Cập nhật">
                {{-- </form> --}}
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('.check-all').click(function() {
            $(this).closest('.card').find('.permission').prop('checked', this.checked)
        })
    </script>
@endsection
