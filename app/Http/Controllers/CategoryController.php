<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){

        $categories = Category::all();


        return view("categories", array(
            'categories' => $categories
        ));
    }

    public function saveCategory(Request $request){
        $data = $request->all();

        $category = new Category();
        $category->name = $data['category'];
        $category->save();

        return redirect(route('posts'));
    }

}
