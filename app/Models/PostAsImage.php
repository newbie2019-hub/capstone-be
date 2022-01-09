<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Str;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\LogOptions;

class PostAsImage extends Model
{
    use LogsActivity, HasFactory, SoftDeletes, MassPrunable, CascadeSoftDeletes;
    public $guarded = [];
    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    protected $cascadeDeletes = ['images'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "Image Update has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['id','status', 'created_at', 'user_account_id', 'post_content_id'])
        ->useLogName('Image as Update')
        ->logOnlyDirty();
    }

    public function user(){
        return $this->belongsTo(UserAccount::class,'user_account_id', 'id');
    }

    public function images(){
        return $this->hasMany(PostImage::class, 'post_as_image_id', 'id');
    }
}
