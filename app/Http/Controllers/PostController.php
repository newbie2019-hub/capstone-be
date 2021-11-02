<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Models\Post;
use App\Models\PostContent;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['uploadPostImage']]);
    }

    public function posts()
    {
        if (Gate::allows('view_all_posts')) {
            if(auth()->user()->type == 'Department'){
                $post = Post::whereHas('useraccount.userinfo.department', function($query){
                    $query->where('id', auth()->user()->userinfo->department->id);
                })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
                return response()->json($post);
            }
            if(auth()->user()->type == 'Organization'){
                $post = Post::whereHas('useraccount.userinfo.organization', function($query){
                    $query->where('id', auth()->user()->userinfo->organization->id);
                })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
                return response()->json($post);
            }
        }
        else {
            $post = Post::with(['postcontent', 'useraccount.userinfo'])->where('user_account_id', auth()->user()->id)->paginate(8);
            return response()->json($post);
        }

    }

    public function approvePost($id){
        $post = Post::where('id', $id)->first();
        if($post){
            $post->update(['status' => 'Approved']);
        }

        return response()->json(['msg' => 'Post has been approved'], 200);
    }

    public function store(Request $request){

        $postcontent = PostContent::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'post_excerpt' => Str::limit($request->post_excerpt, 120, '...'),
        ]);

        if($postcontent){
            Post::create([
                'slug' => $request->title,
                'post_content_id' => $postcontent->id,
                'user_account_id' => auth()->guard('api')->user()->id
            ]);
        }

        return response()->json(['msg' => 'Announcement added successfully!'], 200);
    }
    
    public function updatePost(Request $request, $id){
        $postcontent = PostContent::findOrFail($id);

        $content = [
            'title' => $request->title,
            'content' => $request->content,
            'post_excerpt' => $request->post_excerpt
        ];

        if($request->image){
            $content['image'] = $request->image;
        } 

        $postcontent->update($content);

        $post = Post::findOrFail($id);
        $post->update(['slug' => $request->title]);

        return response()->json(['success' => 'Post updated successfully']);
    }

    public function uploadPostImage(Request $request){
        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deletePost($id){
        $post = PostContent::findOrFail($id);
        Post::where('post_content_id',$id)->delete();
        $post->delete();
        return response()->json(['success' => 'Post deleted successfully']);
    }

    public function searchPost(Request $request){
        $posts = PostContent::where('title', 'like', '%'.$request->search.'%')->orWhere('content', 'like', '%'.$request->search.'%')->paginate(5);
        return response()->json($posts);
    }

}
