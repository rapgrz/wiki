<?php

namespace App\Http\Controllers;

use App\Category;
use App\Comment;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\Paginator;
use App\User;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        $users = User::orderBy('id', 'created_at')->paginate(20);

        return view("users", array(
            'users' => $users
        ));
    }
    public function myInfo($id){
        $user = User::find($id);
        $posts = PostModel::where('user_id', '=', $id);
        $comments = Comment::where('user_id', '=', $id);

        return view("my_info", array(
                'user' => $user,
                'posts' => $posts,
                'comments' => $comments
        ));
    }
    public function userEdit($id){
        $user = User::findOrFail($id);
        return view('user_edit', array(
            'users' => $user
        ));
    }

    public function userUpdate($id){
        $user = User::find($id);
        $user->email = Input::get('email');
        $user->access_level = Input::get('access');
        $user->save();

        return redirect(route('users'));

    }
    
    public function userDelete($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('users'));
    }
}