<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;


class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){

        $posts = PostModel::all();


        return view("posts.index", array(
            'posts' => $posts
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

}
