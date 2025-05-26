@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('nav')
    <nav>
        <ul class="header__nav">
            <li class="header-nav__item">
                <form class="header-nav__link" method="post" action="{{route('logout') }}">
                    @csrf
                    <button class="header-nav__link--button" type="submit">Logout</button>
                    {{--ログアウトボタンを押すと、logoutルートにPOSTリクエストが送信される--}}
                    {{--ログアウト処理は、Laravelによって行われる--}}
                </form>
            </li>
        </ul>
    </nav>
@endsection

@section('content')
<div class="admin__content">
    <div class="admin__heading">
        <h2>Admin</h2>
    </div>
    {{--検索フォーム--}}
    <div class="admin__search">
        <form class="search-form" action="{{ route('admin.search') }}" method="get">
            @csrf
            <div class="search-form__item">
                <input class="search-form__item--text" type="text" name="keyword" value="{{ request('keyword') }}" placeholder="名前やメールアドレスを入力してください">
                {{--value="{{ request('keyword') }}"：検索フォームに入力された値を保持する--}}
                <select class="search-form__item--select" name="gender" value="{{ request('gender') }}">>
                    <option value="" selected disabled>性別</option>
                    {{--option value=""は空にする--}}
                    {{--selected：デフォルトで選択--}}
                    {{--disabled：これを選んだまま送信できなくする--}}
                    <option value="">全て</option>
                    <option value="1">男性</option>
                    <option value="2">女性</option>
                    <option value="3">その他</option>
                </select>
                <select class="search-form__item--select" name="category_id" value="{{ request('category_id') }}">
                    <option value="" selected disabled>お問い合わせの種類</option>
                    {{--option value=""は空にする--}}
                    {{--selected：デフォルトで選択--}}
                    {{--disabled：これを選んだまま送信できなくする--}}
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->content }}</option>
                    @endforeach
                </select>
                <input class="search-form__item--date" type="date" name="date" value="{{ request('date') }}">
                <div class="search-form__item--button">
                    <button class="search-form__item--button-submit" type="submit">検索</button>
                    <a href="{{ route('admin.index') }}" class="search-form__item--button-reset">リセット</a>
                    {{--リセットボタンを押すと、admin.indexに遷移する＝検索フォームが初期化される--}}
                </div>
            </div>
        </form>
    </div>
    <div class="admin__item">
    {{--エクスポートボタン・ページネーション--}}
        <div class="admin-form__export">
            <form action="{{ route('admin.export') }}" method="get">
                @csrf
                <button type="submit">エクスポート</button>
                {{--エクスポートボタンを押すと、admin.exportに遷移する--}}
                {{--エクスポートボタンを押すと、CSVファイルがダウンロードされる?--}}
            </form>
        </div>
        <div class="admin-form__pagination">
            {{ $contacts->links() }}
            <style>
                svg.w-5.h-5{
                    width: 30px;
                    height:30px;
                }
            </style>
        </div>
    </div>

    {{--一覧--}}
    <div class="admin-table">
    <table class="admin-table__inner">
        <tr class="admin-table__row__header">
            <th class="admin-table__header">お名前</th>
            <th class="admin-table__header">性別</th>
            <th class="admin-table__header">メールアドレス</th>
            <th class="admin-table__header">お問い合わせの種類</th>
            <th class="admin-table__header"></th>
        </tr>
        @foreach ($contacts as $contact)
        <tr class="admin-table__row__item">
            <td class="admin-table__item--name">
                {{ $contact->last_name }} {{ $contact->first_name }}
            </td>
            <td class="admin-table__item--gender">
                @if ($contact->gender == 1)
                    男性
                @elseif ($contact->gender == 2)
                    女性
                @else
                    その他
                @endif
            </td>
            <td class="admin-table__item--email">
                {{ $contact->email }}
            </td>
            <td class="admin-table__item--category">
                @if ($contact->category_id == 1)
                商品のお届けについて
                @elseif ($contact->category_id == 2)
                商品の交換について
                @elseif ($contact->category_id == 3)
                商品トラブル
                @elseif ($contact->category_id == 4)
                ショップへのお問い合わせ
                @else
                その他
                @endif
            </td>
            <td class="admin-table__item--button">
                {{-- 詳細ボタンを押すと、モーダルが表示される? --}}
                <button class="admin-table__item-button-detail" type="button" onclick="showDetailModal({{ $contact->id }})">詳細</button>
            </td>
        </tr>
        @endforeach
    </table>
</div>

{{-- モーダルのHTML --}}
<div class="modal" id="detailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);">
    <div class="modal-content" style="background: white; padding: 20px; margin: 100px auto; width: 400px; position: relative;">
        <span class="close" style="position: absolute; top: 10px; right: 15px; cursor: pointer;">&times;</span>

        <p><strong>お名前</strong><span id="modalName"></span></p>
        <p><strong>性別</strong><span id="modalGender"></span></p>
        <p><strong>メールアドレス</strong><span id="modalEmail"></span></p>
        <p><strong>電話番号</strong><span id="modalTel"></span></p>
        <p><strong>住所</strong><span id="modalAddress"></span></p>
        <p><strong>建物名</strong><span id="modalBuilding"></span></p>
        <p><strong>お問い合わせの種類</strong><span id="modalCategory"></span></p>
        <p><strong>お問い合わせ内容</strong><span id="modalDetail"></span></p>

        <form action="{{ route('admin.destroy', $contact->id) }}" method="post" style="display:inline;">
        @csrf
        @method('DELETE')
        <button class="admin-table__item--button-delete" type="submit">削除</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
//Bladeで渡された contacts データを JavaScript に渡す
    const contacts = @json($contacts);
  
    function showDetailModal(id) {
      const contact = contacts.find(c => c.id === id);
      if (!contact) return;
  
        // モーダルの各要素にデータをセット
      document.getElementById('modalName').textContent = contact.first_name + ' ' + contact.last_name;
  
      document.getElementById('modalGender').textContent =
        contact.gender == 1 ? '男性' :
        contact.gender == 2 ? '女性' : 'その他';
  
      document.getElementById('modalEmail').textContent = contact.email;
      document.getElementById('modalTel').textContent = contact.tel || '-';
      document.getElementById('modalAddress').textContent = contact.address || '-';
      document.getElementById('modalBuilding').textContent = contact.building || '-';
  
      const categories = {
        1: '商品のお届けについて',
        2: '商品の交換について',
        3: '商品トラブル',
        4: 'ショップへのお問い合わせ',
      };
      document.getElementById('modalCategory').textContent = categories[contact.category_id] || 'その他';
      
      document.getElementById('modalDetail').textContent = contact.detail || '-';
  
      // モーダルを表示
      document.getElementById('detailModal').style.display = 'block';
    }

    // モーダルを閉じる処理（×ボタンと背景クリック）
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('detailModal');
        const closeBtn = modal.querySelector('.close');

        closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === modal) {
            modal.style.display = 'none';
            }
        });
    });
</script>
@endsection


