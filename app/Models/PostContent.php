<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostContent extends Model
{
    use HasFactory, SoftDeletes, MassPrunable;
    public $guarded = [];

    public function prunable()
    {
        $sched = TaskSchedule::where('task', 'Post Deletion')->first();
        return static::withTrashed()->whereNotNull('deleted_at')->where('deleted_at', '<=', now()->subDays($sched->deletion));
    }

}
