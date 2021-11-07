<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class OSAArchivedPostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(){
        $post = Post::onlyTrashed()->whereHas('useraccount', function($query){
            $query->where('type', 'Organization');
        })->with(['postcontent' => function($query){
            $query->withTrashed();
        }, 'useraccount.userinfo'])->paginate(8);

        return response()->json($post);
    }
}
