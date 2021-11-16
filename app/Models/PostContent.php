<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PostContent extends Model
{
    use HasFactory, SoftDeletes, MassPrunable, LogsActivity;

    public $guarded = [];

    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Content for the post has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()        
        ->logOnly(['id', 'title', 'image', 'post_excerpt', 'content', 'created_at'])
        ->useLogName('Post Content');
    }

    public function prunable()
    {
        $sched = TaskSchedule::where('task', 'Post Deletion')->first();
        return static::withTrashed()->whereNotNull('deleted_at')->where('deleted_at', '<=', now()->subDays($sched->deletion));
    }

}
