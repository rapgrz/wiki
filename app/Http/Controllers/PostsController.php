<?php

namespace App\Http\Controllers;

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
        $parametras = "Mano paasdsadsadsadrametras";

        return view("posts.index", array(
            'posts' => $posts,
            'parametras' => $parametras
        ));
    }
    
    public function create_post()
    {
        return view("create_post.index");
    }

    public function savePost(Request $request){
        $data = $request->all();

        $post = new PostModel();
        $post->content = $data['content'];
        $post->title = $data['title'];
       // $categories->name = $data['categories'];
        $post->user_id =  Auth::user()->id;
        $post->author = Auth::user()->name;
        $post->save();

        return redirect(route('posts'));
    }

}
