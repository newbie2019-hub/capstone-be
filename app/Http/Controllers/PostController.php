<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserInfo;
use App\Models\Post;
use App\Models\PostAsImage;
use App\Models\PostContent;
use App\Models\PostImage;
use App\Models\TaskSchedule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['uploadPostImage']]);
    }

    public function OSAPostSummary(){
        $post = Post::whereHas('useraccount', function($query){
            $query->where('type', 'Organization');
        })->with(['postcontent:id,image,title,content', 'useraccount.userinfo'])->latest()->take(4)->get(['id','user_account_id','post_content_id','status','views','created_at']);

        return response()->json($post);
    }

    public function allposts()
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
            return response()->json(['msg' => 'You don\'t have enough permission to view this post'], 422);
        }

    }

    public function posts()
    {
        // if (Gate::allows('view_all_posts')) {
        //     if(auth()->user()->type == 'Department'){
        //         $post = Post::whereHas('useraccount.userinfo.department', function($query){
        //             $query->where('id', auth()->user()->userinfo->department->id);
        //         })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
        //         return response()->json($post);
        //     }
        //     if(auth()->user()->type == 'Organization'){
        //         $post = Post::whereHas('useraccount.userinfo.organization', function($query){
        //             $query->where('id', auth()->user()->userinfo->organization->id);
        //         })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
        //         return response()->json($post);
        //     }
        // }
        // else {
            $post = Post::with(['postcontent', 'useraccount.userinfo'])->where('user_account_id', auth()->user()->id)->paginate(8);
            return response()->json($post);
        // }

    }

    public function approvePost($id){
        $post = Post::where('id', $id)->first();
        if($post){
            $post->update(['status' => 'Approved']);

            activity('Post Approval')
            ->causedBy(auth('api')->user()->id)
            ->event('approval')
            ->performedOn($post)
            ->log('Post has been approved');
        }

        return response()->json(['msg' => 'Post has been approved'], 200);
    }

    public function store(Request $request){

        if($request->type == 'text'){
            $post_excerpt = Str::limit($request->post_excerpt, 146, ' ...');
            
            $postcontent = PostContent::create([
                'title' => $request->title,
                'content' => $request->content,
                'image' => $request->image,
                'post_excerpt' => $post_excerpt
            ]);
            
    
            $post = [
                'post_content_id' => $postcontent->id,
                'user_account_id' => auth()->guard('api')->user()->id
            ];
    
            if(auth()->user()->userinfo->role->role == 'President' || auth()->user()->userinfo->role->role == 'Unit Chair' || auth()->user()->userinfo->role->role == 'OSA' || auth()->user()->userinfo->role->role == 'University Admin'){
                $post['status'] = 'Approved';
            }
    
            Post::create($post);
        }
        else {
            $post = [
                'title' => $request->title,
                'user_account_id' => auth()->guard('api')->user()->id
            ];

            if(auth()->user()->userinfo->role->role == 'President' || auth()->user()->userinfo->role->role == 'Unit Chair' || auth()->user()->userinfo->role->role == 'OSA' || auth()->user()->userinfo->role->role == 'University Admin'){
                $post['status'] = 'Approved';
            }

            $postimg = PostAsImage::create($post);

            foreach($request->imageupdate as $imgupdate){
                PostImage::create([
                    'post_as_image_id' => $postimg->id,
                    'image' => $imgupdate
                ]);
            }
            
            return response()->json(['msg' => 'Update type is set to image']);
        }

        return response()->json(['msg' => 'Post added successfully!'], 200);
    }
    
    public function updatePost(Request $request, $id){
        $post_excerpt = Str::limit($request->post_excerpt, 146, ' ...');

        $postcontent = PostContent::findOrFail($id);

        $content = [
            'title' => $request->title,
            'content' => $request->content,
            'post_excerpt' => $post_excerpt
        ];

        if($request->image){
            $content['image'] = $request->image;
        } 

        $postcontent->update($content);

        return response()->json(['success' => 'Post updated successfully']);
    }

    public function uploadPostImage(Request $request){
        $picName = time().rand(10, 400).'.'.$request->file->extension();
        $request->file->move(public_path('uploads'), $picName);
        return $picName;
    }

    public function deletePost($id){
        $post = Post::find($id);
        $post->delete();
        return response()->json(['success' => 'Post deleted successfully']);
    }

    public function searchPost(Request $request){
        if (Gate::allows('view_all_posts')) {
            if(auth()->user()->type == 'Department'){
                $post = Post::whereRelation('useraccount.userinfo', 'first_name', 'like', '%'.$request->search.'%')
                ->whereRelation('postcontent', 'title', 'like', '%'.$request->search.'%')
                ->whereHas('useraccount.userinfo.department', function($query){
                    $query->where('id', auth()->user()->userinfo->department->id);
                })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
                return response()->json($post);
            }
            if(auth()->user()->type == 'Organization'){
                $post = Post::whereRelation('useraccount.userinfo', 'first_name', 'like', '%'.$request->search.'%')
                ->orWhereRelation('postcontent', 'title', 'like', '%'.$request->search.'%')
                ->whereHas('useraccount.userinfo.organization', function($query){
                    $query->where('id', auth()->user()->userinfo->organization->id);
                })->with(['postcontent', 'useraccount.userinfo'])->paginate(8);
                return response()->json($post);
            }
        }
        else {
            $post = Post::whereRelation('postcontent', 'title', 'like', '%'.$request->search.'%')->with(['postcontent', 'useraccount.userinfo'])->where('user_account_id', auth()->user()->id)->paginate(8);
            return response()->json($post);
        }

        // $posts = PostContent::where('title', 'like', '%'.$request->search.'%')->orWhere('content', 'like', '%'.$request->search.'%')->paginate(5);
        // return response()->json($posts);
    }

    public function getSchedule(){
        return response()->json(TaskSchedule::where('task', 'Post Deletion')->first());
    }

    public function setSchedule(Request $request){
        $task = TaskSchedule::where('task', 'Post Deletion')->first();
        if($task){
            $task->update(['deletion' => $request->schedule]);
        }
        else {
            TaskSchedule::create([
                'task' => 'Post Deletion',
                'deletion' => $request->schedule,
            ]);
        }

        return response()->json(['msg' => 'Schedule set successfully!']);
    }

}
