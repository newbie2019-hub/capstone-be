<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes, MassPrunable;
    public $guarded = [];

    public function useraccount(){
        return $this->belongsTo(UserAccount::class,'user_account_id', 'id');
    }

    public function postcontent(){
        return $this->belongsTo(PostContent::class,'post_content_id', 'id');
    }

    public function setSlugAttribute($title){
        return $this->attributes['slug'] = $this->uniqueSlug($title);
    }

    public function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }

    public function prunable()
    {
        $sched = TaskSchedule::where('task', 'Post Deletion')->first();
        return static::withTrashed()->whereNotNull('deleted_at')->where('deleted_at', '<=', now()->subDays($sched->deletion));     
    }
}
