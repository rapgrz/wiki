<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Files;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        $posts = PostModel::all();
        $categories = Category::orderBy('id', 'created_at')->paginate(10);


        return view("categories", array(
            'categories' => $categories,
            'posts' => $posts
        ));
    }
    public function destroy($id){
        $category = Category::findOrFail($id);
        
        foreach ($category->post as $post){
            $category_ids[] =  $post->id;
            foreach ($category_ids as $ids){
                $files = Files::where('post_id', '=', $ids)->get();
            }
        }
        if(isset($files)){
            foreach ($files as $file){
                $success = Storage::disk()->delete('/'.$file->path);
            }
        }
        $category->delete();

        return redirect(route('categories'));
    }
    public function saveCategory(Request $request){
        $data = $request->all();

        $validatedData = $request->validate([
            'name' => 'unique:categories|max:255'
        ]);

        $category = new Category();
        $category->name = $data['name'];
        $category->save();

        return response()->json([
            'name' => $category->name,
            'id' => $category->id
        ]);

       // return redirect(route('categories'));
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
