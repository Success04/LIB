@extends('layouts.app')

@push('css')
    <style>
        .is-invalid-label {
            border: 1px solid tomato;
        }

        .imagePreview {
            height: 200px;
            max-width: 140px;
        }
        img{
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('会員登録') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group text-center">
                            {{-- プレヴュー画面 --}}
                            <label class="imagePreview mx-auto col-md-6 p-0 d-block @error('image') is-invalid-label @enderror" for="profiel">
                                <img class="h-100 w-100 object-fit:cover;" src="" alt="profile画像" id="profiel_img">
                            </label>
                            {{-- エラーメッセージ--}}
                            @if ($errors->has('image'))
                                <span class="text-danger">{{ $errors->first('image') }}</span>
                            @endif

                            <div class="input-group offset-md-4 col-md-8 mt-3 text-left">
                                <div class="custom-file">
                                    {{-- :file--}}
                                    <input type="file" id="profiel" class="profiel_img" name="image" accept=".png,.jpg,.jpeg" />
                                    <label class="custom-file-label @error('image') is-invalid-label @enderror" for="profiel" data-browse="参照">profiel_img</label>
                                </div>
                                {{-- 取り消しボタン--}}
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary reset">取消</button>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('名前') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('パスワード') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('パスワード確認') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('会員登録') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
        <script>
        $(document).on('change', ':file', function() {
            var files = this.files ? this.files : [];
            //空なら終了
            if (!files.length || !window.FileReader) return;
            //ファイル名をlavelに追記
            $(this).next('.custom-file-label').text(files[0].name);
            //タイプがimageなら
            if (/^image/.test(files[0].type)) {
            // FileReader関数
                var reader = new FileReader();
                reader.readAsDataURL(files[0]);
                reader.onloadend = function() {
                //srcに画像のurl(this.result)を記入
                    $('#profiel_img').attr('src', this.result);
                }
            }
        });

        //ファイルの取消
        $('.reset').click(function() {
            $('.custom-file-label').html('ファイル選択...');
            $('#profiel_img').attr('src', '');
            $(':file').val(null);
        })
        </script>
    @endpush
