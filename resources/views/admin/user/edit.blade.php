@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa thông tin quản trị viên
        </div>
        <div class="card-body">
            {{-- <form method="POST" action="{{route('user.update', $user->id)}}"> --}}
            {!! Form::open(['route'=>['user.update', $user->id]]) !!}
                @csrf
                <div class="form-group">
                    {{-- <label for="name">Họ và tên</label>
                    <input class="form-control" type="text" name="name"  value="{{$user->name}}" id="name"> --}}
                    {!! Form::label('name', 'Họ và tên') !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control', 'id'=>'name']) !!}
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <label for="email">Email</label>
                    <input class="form-control" type="text" name="email" id="email" disabled value="{{$user->email}}"> --}}
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', $user->email, ['class' => 'form-control', 'id'=>'email']) !!}
                    @error('email')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <label for="password">Mật khẩu</label>
                    <input class="form-control" type="password" name="password" id="password"> --}}
                    {!! Form::label('password', 'Mật khẩu') !!}
                    {!! Form::password('password', ['class'=>'form-control', 'id'=>'password']) !!}
                    @error('password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {{-- <label for="password-confirm">Xác nhận mật khẩu</label>
                    <input class="form-control" type="password" name="password_confirmation" id="password-confirm"> --}}
                    {!! Form::label('password-confirm', 'Xác nhận mật khẩu') !!}
                    {!! Form::password('password_confirmation', ['class'=>'form-control', 'id'=>'password-confirm']) !!}
                </div>
                <div class="form-group">
                    {{-- <label for="">Nhóm quyền (vai trò)</label>
                    <select class="form-control" multiple name="roles[]" id="">
                        @foreach ($roles as $role)
                            <option class="active" value="{{$role->id}}">{{$role->name}}</option>
                        @endforeach
                    </select> --}}
                    {!! Form::label('roles', 'Nhóm quyền (vai trò)') !!}
                    @php
                        $selectedRoles = $user->roles->pluck('id')->toArray();
                        $options = $roles->pluck('name', 'id')->toArray();  // id là value của options, name là gt hiển thị
                    @endphp
                    {!! Form::select('roles[]', $options, $selectedRoles, ['class'=>'form-control', 'id'=>'roles', 'multiple'=>true]) !!}
                </div>

                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection