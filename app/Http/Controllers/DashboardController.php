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

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //

    public function index(){
        $posts = PostModel::all();
        $categories = Category::all();
        $users = User::all();
        $comments = Comment::all();
        $files = Files::all();
        $latestPost = PostModel::latest()->first();
        $latestComment = Comment::latest()->first();

        return view("dashboard", array(
            'posts' => $posts,
            'categories' => $categories,
            'users' => $users,
            'comments' => $comments,
            'files' => $files,
            'latestPost' => $latestPost,
            'latestComment' => $latestComment
        ));
    }
    public function postsInThisMonth(){
        $dates = collect();
        foreach( range( -30, 0 ) AS $i ) {
            $date = Carbon::now()->addDays( $i )->format( 'Y-m-d' );
            $dates->put( $date, 0);
        }
        $posts = PostModel::where( 'created_at', '>=', $dates->keys()->first() )
            ->groupBy( 'date' )
            ->orderBy( 'date' )
            ->get( [
                DB::raw( 'DATE( created_at ) as date' ),
                DB::raw( 'COUNT( * ) as "count"' )
            ] )
            ->pluck( 'count', 'date' );
        $dates = $dates->merge( $posts );
        return response()->json([
            'dates' => $dates
        ]);
    }
}