@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('マッチ一覧') }}</div>

                <div class="card-body">
                    <div class="row">
                        @foreach ($users as $key => $user)
                            <div class="col-12 mb-3">
                                <img src="{{ asset($user->img_url) }}" class="rounded-circle" height="70px" width="70px" alt="">
                                <a href="{{ route('users.matches_show',$key) }}" class="ml-3" style="font-size:16px;">
                                    {{ $user->name }}
                                </a>
                                <a href="{{ route('users.room',$user['id']) }}" class="float-end btn btn-primary">
                                    メッセージを送る
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
