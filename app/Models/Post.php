<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Str;
use Spatie\Activitylog\LogOptions;

class Post extends Model
{ 
    use LogsActivity, HasFactory, SoftDeletes, MassPrunable;

    public $guarded = [];
    protected static $logFillable = true;
    protected static $logAttributes = ['*'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A post has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id','status', 'created_at', 'user_account_id', 'post_content_id'])
        ->useLogName('Post');
    }

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
