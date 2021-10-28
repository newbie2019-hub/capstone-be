<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostContent;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminUpdateController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['uploadPostImage']]);
    }

    public function index()
    {
        $post = Post::with('postcontent')->where('user_account_id', auth()->user()->id)->paginate(8);
        return response()->json($post);
    }

    public function store(Request $request){

        $post_excerpt = Str::limit($request->content, 120, '...');

        $postcontent = PostContent::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'post_excerpt' => $post_excerpt,
        ]);

        $account_info = UserInfo::where('id', auth()->guard('admin')->user()->id)->first();

        if($postcontent){
            Post::create([
                'slug' => $request->title,
                'post_content_id' => $postcontent->id,
                'user_account_id' => $account_info->id
            ]);
        }
        return response()->json(['msg' => 'Announcement added successfully!'], 200);
    }

    public function update(Request $request, $id){
        $postcontent = PostContent::findOrFail($id);

        $content = [
            'title' => $request->title,
            'content' => $request->content,
            'post_type_id' => $request->type
        ];

        if($request->image){
            $content['image'] = $request->image;
        } 

        $postcontent->update($content);
        return response()->json(['success' => 'Post updated successfully']);
    }

    public function destroy($id){
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
