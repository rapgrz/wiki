<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){

        $posts = PostModel::paginate(10);
        $categories = Category::all();

        return view("posts.index", array(
            'posts' => $posts,
            'categories' => $categories
        ));
    }
    
    public function create_post()
    {
        $categories = Category::all();
        
        return view("create_post.index", array('categories' => $categories));
    }

    public function savePost(Request $request){
        $data = $request->all();

        $post = new PostModel();
        $post->content = $data['content'];
        $post->title = $data['title'];
        $post->category_id = $data['category_id'];
        $post->user_id =  Auth::user()->id;
        //$post->author = Auth::user()->name;
        $post->save();

        return redirect(route('posts'));
    }
    public function show($id){
        $post = PostModel::find($id);
        return view('posts.edit');
    }

    public function destroy($id){
        $post = PostModel::findOrFail($id);
        $post->delete();

        return redirect(route('posts'));
    }
    
    public function edit($id){
        $post = PostModel::findOrFail($id);

        return view('posts.edit');
    }

    public function update($id){
        $post = PostModel::find($id);
        $post->title       = Input::get('title');
        $post->content      = Input::get('content');
        $post->category = Input::get('category');
        $post->save();


    }
}
