@extends('layouts.app')

@section('content')
    <div class="container col-md-8">

        <div class="row justify-content-center">
            <div class="card text-center" style="">
                <img src="{{ asset($main_user->img_url) }}" class="mx-auto" alt="{{ $main_user->name }}"
                    style="height:400px;width:300px;object-fit:cover;object-position:center;">
                <div class="card-body">
                    <h5 class="card-title">{{ $main_user->name }}</h5>
                    <p class="card-text">{{ $main_user->email }}</p>

                    <div class="d-flex flex-column">

                        <div class="d-flex justify-content-center flex-wrap order-md-2">
                            @foreach ($match_users as $key => $user)
                                <a class="btn border-primary mb-2 @if ($num == $key) btn-primary  @endif"
                                    href="{{ route('users.matches_show', $key) }}">{{ $key + 1 }}</a>
                            @endforeach
                        </div>
                        <a class="btn btn-primary mb-2 d-flex flex-column justify-content-center order-md-1"
                            href="{{ route('users.matches_show', $prev) }}">前</a>
                        <a class="btn btn-primary mb-2 order-md-3" href="{{ route('users.matches_show', $next) }}">次へ</a>

                    </div>
                    <div class="mt-3">
                        <a href="{{ route('users.room', $main_user->id) }}" class="btn btn-primary">連絡をとる</a>
                        <a href="{{ route('users.matches') }}" class="btn btn-primary">戻る</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
