@extends('layouts.admin')
@section('content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Chỉnh sửa thông tin đơn hàng
        </div>
        <div class="card-body">
            {{-- <form method="POST" action="{{route('user.update', $user->id)}}"> --}}
            {!! Form::open(['route'=>['order.update', $info_order->id]]) !!}
                @csrf
                <div class="form-group">
                    {!! Form::label('name', 'Họ và tên') !!}
                    {!! Form::text('name', $info_order->client, ['class' => 'form-control', 'id'=>'name']) !!}
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('address', 'Địa chỉ') !!}
                    {!! Form::text('address', $info_order->address, ['class' => 'form-control', 'id'=>'address']) !!}
                    @error('address')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('tel', 'Số điện thoại') !!}
                    {!! Form::tel('tel', '0'. $info_order->phone, ['class' => 'form-control', 'id'=>'tel']) !!}
                    @error('tel')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-group">
                    {!! Form::label('email', 'Email') !!}
                    {!! Form::email('email', $info_order->email, ['class' => 'form-control', 'id'=>'email']) !!}
                    @error('email')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>

                <button type="submit" name="btn_update" class="btn btn-primary">Cập nhật</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection