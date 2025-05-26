<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Contact::with('category')->get();
        //with()メソッドを使用して、リレーション関係にあるCategoryモデルのデータを取得//

        $categories = Category::all();

        $contacts = Contact::Paginate(7);
        //ページネーションを使用して、1ページに7件のデータを表示//

        return view('admin', compact('contacts', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        //IDを指定して、Contactモデルのデータを取得//
        $category = Category::find($contact->category_id);
        //IDを指定して、Categoryモデルのデータを取得//
        return view('admin.show', compact('contact', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Contact::destroy($id);

        return redirect()->route('admin.index');
    }

    public function search(Request $request)
    {
        $contacts = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)
        ->DateSearch($request->created_at)->Paginate(7)
        ->appends($request->all());
        //appends()メソッドを付けることで、ページ移動時も検索条件が維持される//

        $categories = Category::all();

        return view('admin', compact('contacts', 'categories'));
    }

    public function export(Request $request)
    {
        //後で記述
    }
}
