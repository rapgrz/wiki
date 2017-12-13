<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        $posts = PostModel::all();
        $categories = Category::all();


        return view("categories", array(
            'categories' => $categories,
            'posts' => $posts
        ));
    }
    public function destroy($id){
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect(route('categories'));
    }
    public function saveCategory(Request $request){
        $data = $request->all();

        $category = new Category();
        $category->name = $data['category'];
        $category->save();

        return redirect(route('categories'));
    }

    public function edit($id){
        $category = Category::findOrFail($id);
        return view('category_edit', array(
            'categories' => $category
        ));
    }

    public function update($id){
        $category = Category::find($id);
        $category->name = Input::get('name');
        $category->save();

        return redirect(route('categories'));

    }
}
