@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__header">
        <h2>Contact</h2>
    </div>
    <form class="form" action="/confirm" method="post">
    @csrf
    <div class="form__wrapper">
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="first_name" class="form__input" value="{{ old('first_name') }}" placeholder="例:山田">
                    <input type="text" name="last_name" class="form__input" value="{{ old('last_name') }}" placeholder="例:太郎">
                </div>
                <div class="form__error">
                    @error('first_name')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('last_name')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--radio">
                    <input type="radio" name="gender" value="1" checked>男性
                    <input type="radio" name="gender" value="2">女性
                    <input type="radio" name="gender" value="3">その他
                </div>
                <div class="form__error">
                    @error('gender')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">メールアドレス</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" name="email" class="form__input" value="{{ old('email') }}" placeholder="例:test@example.com">
                </div>
                <div class="form__error">
                    @error('email')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">電話番号</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="tel1" class="form__input" value="{{ old('tel1') }}" placeholder="080"> - <input type="text" name="tel2" class="form__input" value="{{ old('tel2') }}" placeholder="1234"> - <input type="text" name="tel3" class="form__input" value="{{ old('tel3') }}" placeholder="5678">
                </div>
                <div class="form__error">
                    @error('tel1')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('tel2')
                        {{ $message }}
                    @enderror
                </div>
                <div class="form__error">
                    @error('tel3')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">住所</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="address" class="form__input" value="{{ old('address') }}" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3">
                </div>
                <div class="form__error">
                    @error('address')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">建物名</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" name="building" class="form__input" value="{{ old('building') }}" placeholder="例:千駄ヶ谷マンション101">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">お問い合わせの種類</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select name="category_id" class="form__select">
                        <option value="" selected disabled>選択してください</option>{{--option value=""は空にする--}}
                        {{--selected：デフォルトで選択--}}
                        {{--disabled：これを選んだまま送信できなくする--}}
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->content }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('category_id')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form-group-title">
                <span class="form__label--item">お問い合わせ内容</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea name="detail" class="form__input" value="{{ old('detail') }}" placeholder="お問い合わせ内容をご記載ください"></textarea>
                </div>
                <div class="form__error">
                    @error('detail')
                        {{ $message }}
                    @enderror
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </div>
    </form>
</div>

@endsection
