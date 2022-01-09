<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class PostImage extends Model
{
    use HasFactory, SoftDeletes, MassPrunable, LogsActivity;
    public $guarded = [];

    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Update Images for the post has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()        
        ->logOnly(['id', 'title', 'image', 'created_at'])
        ->useLogName('Update Images')
        ->logOnlyDirty();
        
    }
}
