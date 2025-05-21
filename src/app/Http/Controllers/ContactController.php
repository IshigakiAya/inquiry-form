<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Models\Category;

class ContactController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        //シーダーで登録したデータを全件取得
        return view('index', compact('categories'));
    }

    public function confirm(ContactRequest $request)
    {
        $contact = $request->only([
            'first_name', 'last_name', 'gender', 'email',
            'address', 'building', 'category_id', 'detail'
        ]);
        $contact['tel'] = $request->input('tel1') . $request->input('tel2') . $request->input('tel3');
        //電話番号を結合

        $request->session()->put('contact', $contact);
        //セッションに保存

        return view('confirm', ['contact' => (object) $contact]);
        //オブジェクトに変換して渡す
    }

    public function store(Request $request)
    {
        $contact = $request->session()->get('contact');
        //セッションから取得

        Contact::create($contact);
        //Contactモデルに保存
        $request->session()->forget('contact');
        //セッションに保存したデータを削除

        return view('thanks');
    }
}
