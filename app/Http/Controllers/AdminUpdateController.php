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
        $post = Post::withTrashed()->with(['postcontent' => function($query){
            $query->withTrashed();
        }, 'useraccount'  => function($query){
            $query->withTrashed();
        }, 'useraccount.userinfo'  => function($query){
            $query->withTrashed();
        }])->paginate(10);
        return response()->json($post);
    }

    public function searchPost(Request $request){
        $posts = Post::whereHas('postcontent',function($query){
            $query->where('title', 'like', '%'.request()->get('search').'%');
        })->orWhereHas('useraccount.userinfo', function($query){
            $query->where('first_name', 'like', '%'.request()->get('search').'%')
            ->orWhere('last_name', 'like', '%'.request()->get('search').'%');
        })->with(['postcontent', 'useraccount.userinfo'])->paginate(10);
        return response()->json($posts);
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

    public function restore($id){
        Post::where('id',$id)->restore();
        PostContent::where('id', $id)->restore();

        return response()->json(['success' => 'Post restored successfully']);
    }

    public function destroy($id){
        $post = PostContent::findOrFail($id);
        Post::where('post_content_id',$id)->delete();
        $post->delete();
        return response()->json(['success' => 'Post deleted successfully']);
    }

}
