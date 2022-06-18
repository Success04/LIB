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

<div class="img border rounded mx-auto text-center py-2" style="">
    {{-- ユーザーの画像 --}}
    {{-- <img src="{{ asset($user->img_url) }}" alt="" class=""
        style="width:350px;height:400px;object-fit:cover;object-position:center;"> --}}
    <h2>{{ $user->name }} 23</h2>
    <h3>自己紹介</h3>
    <h3>こんにちは！</h3>
</div>

    <div class="row mt-1 justify-content-center align-items-center text-center" style="height:200px">

            {{-- 緑のボタン --}}
            <div class="col-6">
                <form action="{{ route('users.store', $user) }}" method="POST">
                    @csrf
                    <input type="hidden" name="to_user_id" value="{{ $user->id }}">
                    <input type="hidden" name="from_user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="is_like" value="0">
                    <button class="tno rounded-circle bg-white p-3 px-4" type="submit">
                        <i class="fa fa-times" aria-hidden="true"></i>
                    </button>
                </form>
            </div>

            {{-- 赤のボタン --}}
            <div class="col-6">

                <form action="{{ route('users.store', $user) }}" method="POST">
                    @csrf
                    <input type="hidden" name="to_user_id" value="{{ $user->id }}">
                    <input type="hidden" name="from_user_id" value="{{ Auth::id() }}">
                    <input type="hidden" name="is_like" value="1">
                    <button class="tyes rounded-circle bg-white p-3" type="submit">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </button>
                </form>
            </div>
    </div>
