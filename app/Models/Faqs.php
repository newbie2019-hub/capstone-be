<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class Faqs extends Model
{
    use HasFactory, LogsActivity;
    public $guarded = [];

    protected static $logFillable = true;
    protected static $logAttributes = ['*'];

    public function getDescriptionForEvent(string $eventName): string
    {
        return "A frequently asked question has been {$eventName}.";
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()        
        ->logAll()
        ->useLogName('Frequently Asked Questions');
    }
}
