@extends('layouts.app')

@push('css')
    <style>
        .tno i{
            color: tomato;
            font-size: 80px;
        }

        .tyes i{
            /* color: #5de19c; */
            font-size: 80px;
            color: #5de19c;
        }

    </style>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="min-height: 800px">
                    {{-- マッチしましたとフラッシュメッセージで表示 --}}
                    @if (session('flash_message'))
                        <div class="flash_message bg-success text-center py-3 my-0">
                            {{ session('flash_message') }}
                        </div>
                    @endif

                    <div class="card-header bg-white">
                    {{-- if文でuserが存在する時としない時で表示を区別 --}}
                        @if (is_null($user))
                            <p class="text-center my-auto">あなたの周りにユーザーはいません。</p>
                        @else
                            名前:{{ $user->name }}
                        @endif
                    </div>
                    
                    <div class="card-body">
                        {{-- 指定する論理式がtrueかfalseと評価された場合に、ビューを@includeする。 --}}
                        @includeWhen(isset($user), 'users.matching_form')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
