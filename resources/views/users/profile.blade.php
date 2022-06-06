@extends('layouts.app')
@section('content')
    <div class="card w-50 mx-auto m-5">
        <div class="card-body">
            <div class="pt-2">
                <p class="h3 border-bottom border-secondary pb-3">プロフィール編集</p>
            </div>
            {!! Form::open(['route' => ['profile_edit'], 'method' => 'PUT']) !!}
            {!! Form::hidden('id',$user->id) !!}
            <div class="m-3">
                <div class="form-group pt-1">
                    {{Form::label('name','ユーザー名')}}
                    {{Form::text('name', $user->name, ['class' => 'form-control', 'id' =>'name'])}}
                    <span class="text-danger">{{$errors->first('name')}}</span>
                </div>
                <div class="form-group pt-2">
                    {{Form::label('email','メールアドレス')}}
                    {{Form::email('email', $user->email, ['class' => 'form-control', 'id' =>'email'])}}
                    <span class="text-danger">{{$errors->first('email')}}</span>
                </div>
                <div class="form-group pt-2">
                    <p>パスワード</p>
                    <div class="row g-3">
                        <div class="col-md-2">
                            <a>********</a>
                        </div>
                        <div class="col-md-10">
                            <button type="button" class="btn-sm btn-success rounded-pill" data-toggle="modal"
                                    data-target="#exampleModal">パスワードを更新する
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group pull-right">
                    {{Form::submit(' 更新する ', ['class'=>'btn btn-success rounded-pill'])}}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <p class="modal-title">パスワード更新</p>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => ['password_edit'], 'method' => 'PUT']) !!}
                    {!! Form::hidden('id', $user->id) !!}
                    <div class="form-group pt-1">
                        {{Form::label('password','新しいパスワード')}}
                        {{Form::password('password', ['class' => 'form-control', 'id' =>'password'])}}
                        <span class="text-danger">{{$errors->first('password')}}</span>
                    </div>
                    <div class="form-group pt-1">
                        {{Form::label('password_confirmation','新しいパスワード（確認）')}}
                        {{Form::password('password_confirmation', ['class' => 'form-control', 'id' =>'password_confirmation'])}}
                        <span class="text-danger">{{$errors->first('password_confirmation')}}</span>
                    </div>
                    <div class="w-25">
                        {{Form::submit(' 更新する ', ['class'=>'btn btn-success rounded-pill'])}}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    @if ($errors->any())
        <script>
            $(function () {
                $('#exampleModal').modal();
            });
        </script>
    @endif
@endsection
