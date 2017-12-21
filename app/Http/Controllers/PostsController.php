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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\User;
use App\Files;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){

        $posts = PostModel::orderBy('id', 'created_at')->paginate(10);
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
        //$fileDir = $request->file($data['fileName'])->store('docs', $data['fileName']);
        //$path = Storage::putFile('docs', $request->file($data['file']));

        $validatedData = $request->validate([
            'content' => 'required|min:20',
            'title' => 'required|between:5,100'
        ]);

        $post = new PostModel();
        //$file = new Files();

        //$file->name = $data['file']->getClientOriginalName();
        //$file->path = $data['file']->getRealPath();
        
        $post->content = $data['content'];
        $post->title = $data['title'];
        $post->category_id = $data['category_id'];
        $post->user_id =  Auth::user()->id;
       // $file->post_id = $post->id;
        $post->save();
        //$file->save();

        return response()->json([
            'content' => $post->content,
        ]);
    }

    public function destroy($id){
        $post = PostModel::findOrFail($id);
        $post->delete();

        return redirect(route('posts'));
    }
    
    public function edit($id){
        $post = PostModel::findOrFail($id);
        $categories = Category::all();

        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    public function update($id){
        $post = PostModel::find($id);
        
        $post->title = Input::get('title');
        $post->content = Input::get('content');
        $post->category_id = Input::get('category_id');
        $post->save();

        return redirect(route('posts'));

    }

    public function search(Request $request){
        $data = $request->all();
        $search = $data['search'];
        $filter = $data['searchBy'];
        $categories = Category::all();
        $posts = PostModel::where($filter, 'like', "%$search%")->paginate(10);

            return view("posts.index", array(
                'posts' => $posts
            ));

    }
    
    public function search_category($id){
        $posts = PostModel::where('category_id', '=', $id)->paginate(10);
        $categories = Category::all();

        return view("posts.index", array(
            'posts' => $posts
        ));
    }
    public function postShow($id){
        $comment = Comment::orderBy('id', 'created_at')->paginate(3);
        $post = PostModel::find($id);
        $user = User::find($id);
       
        return view("posts.show", array(
           'post' => $post,
            'user' => $user,
            'comment' => $comment
        ));
    }
    public function addComment(Request $request, $id){
        $data = $request->all();

        $validatedData = $request->validate([
            'content' => 'required|between:5,10000'
        ]);

        $comment = new Comment();

        $comment->content = $data['content'];
        $comment->post_id = $id;
        $comment->user_id =  Auth::user()->id;
        $comment->save();


        return response()->json([
            'content' => $comment->content,
            'post_id' => $comment->post_id,
            'user_id' => $comment->user_id,
            'user_name' => Auth::user()->name,
            'comment_id' => $comment->id,
            'created_at' => $comment->created_at
        ]);
    }
    public function destroyComment($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->back();
    }
    public function editComment($id){
        $post = PostModel::all();
        $comment = Comment::findOrFail($id);


        return view('posts.editComment', [
            'post' => $post,
            'comment' => $comment
        ]);
    }
    public function updateComment($id){
        $comment = Comment::find($id);
        $comment->content = Input::get('content');
        $comment->save();

        return redirect(route('posts'));

    }
}
