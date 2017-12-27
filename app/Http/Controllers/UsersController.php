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
    public function profile($id){
        $user = User::find($id);
        $posts = PostModel::where('user_id', '=', $id);
        $comments = Comment::where('user_id', '=', $id);

        return view("profile", array(
                'user' => $user,
                'posts' => $posts,
                'comments' => $comments
        ));
    }
    public function uploadAvatar($id){
        $user = User::findOrFail($id);
        return view('upload_avatar', array(
            'user' => $user
        ));
    }
    public function saveAvatar(Request $request){
        $data = $request->all();
        $user = Auth::user();
        $validatedData = $request->validate([
            'avatar' => 'required|mimes:jpeg,bmp,png,gif'
        ]);

        $avatar = $request->file('avatar');
        $avatar_name = $avatar->getClientOriginalName();
        $avatar_path = $avatar->store('avatars');

        $user->avatar = $avatar_name;
        $user->avatar_path = $avatar_path;

        $user->save();
        return redirect(route('profile', ['user_id' => $user->id]));

    }
    public function userEdit($id){
        $user = User::findOrFail($id);
        return view('user_edit', array(
            'user' => $user
        ));
    }

    public function userUpdate($id){
        $user = User::find($id);
        $user->email = Input::get('email');
        $user->access_level = Input::get('access');
        $user->name = Input::get('name');
        $user->save();

        return redirect(route('users'));

    }
    
    public function userDelete($id){
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('users'));
    }
}