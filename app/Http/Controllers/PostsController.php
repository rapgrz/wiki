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
use Carbon\Carbon;

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

        $validatedData = $request->validate([
            'content' => 'required|min:20',
            'title' => 'required|between:5,100'
        ]);

        $post = new PostModel();

        $post->content = $data['content'];
        $post->title = $data['title'];
        $post->category_id = $data['category_id'];
        $post->user_id =  Auth::user()->id;
        $post->save();


        $files = $request->file('file');

        if(isset($files)){
            foreach($files as $file){
                $file_path = $file->store('files');
                $file_name = $file->getClientOriginalName();
                $saveFile = new Files();

                $saveFile->name = $file_name;
                $saveFile->path = $file_path;
                $saveFile->post_id = $post->id;

                $saveFile->save();
            }
        }

        return redirect(route('posts'));
    }

    public function destroy($id){
        $post = PostModel::findOrFail($id);
        $fileCheck = Files::where('post_id', '=', $id);
        if(isset($fileCheck)){
            foreach ($post->files as $file){
                $file = Storage::disk()->delete('/'.$file->path);
            }
        }
        $post->delete();

        return redirect(route('posts'));
    }
    
    public function edit($id){
        $post = PostModel::findOrFail($id);
        $files = Files::where('post_id', '=', $id)->get();
        $categories = Category::all();

        return view('posts.edit', [
            'post' => $post,
            'categories' => $categories,
            'files' => $files
        ]);
    }

    public function update(Request $request, $id){
        $post = PostModel::find($id);
        $files = Files::where('post_id', '=', $id)->get();
        $check = Input::get('Check');
        $uploadFiles = $request->file('file');
        if(isset($check)){
            foreach ($files as $file){
                $file = Storage::disk()->delete('/'.$file->path);
            }
            $files = Files::where('post_id', '=', $id)->delete();
        }
        if(isset($uploadFiles)){
            foreach($uploadFiles as $uploadFile){
                $file_path = $uploadFile->store('files');
                $file_name = $uploadFile->getClientOriginalName();
                $saveFile = new Files();

                $saveFile->name = $file_name;
                $saveFile->path = $file_path;
                $saveFile->post_id = $id;

                $saveFile->save();
            }
        }
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
        $fileCheck = Files::where('post_id', '=', $id)->count();
        $user = User::find($id);
       
        return view("posts.show", array(
           'post' => $post,
            'user' => $user,
            'comment' => $comment,
            'fileCheck' => $fileCheck
        ));
    }
    public function addComment(Request $request, $id){
        $data = $request->all();

        $validatedData = $request->validate([
            'content' => 'required|between:5,30000'
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
            'user_avatar' => $comment->user->avatar_path,
            'user_name' => Auth::user()->name,
            'comment_id' => $comment->id,
            'created_at' => $comment->created_at->diffForHumans()
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

        return redirect(route('postShow', ['post_id' => $comment->post_id]));

    }
}
