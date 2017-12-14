<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\PostModel;
use Illuminate\Http\Request;
use Faker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function index(){
        $users = User::all();


        return view("users", array(
            'users' => $users
        ));
    }
}