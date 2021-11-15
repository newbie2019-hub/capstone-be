<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TelephoneDirectory extends Model
{
    use HasFactory, LogsActivity;
    public $guarded = [];

    protected static $logFillable = true;
    protected static $logAttributes = ['*'];
    
    public function getDescriptionForEvent(string $eventName): string
    {
        return "A telephone record has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()        
        ->logAll()
        ->useLogName('Telephone Directory');
    }
}
