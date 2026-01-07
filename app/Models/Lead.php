<?php

namespace App\Models;

use App\Enums\LeadStatus;
use App\Enums\PropertyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Lead extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'source_page',
        'source',
        'property_type',
        'name',
        'email',
        'phone',
        'message',
        'status',
        'utm_json',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'property_type' => PropertyType::class,
        'status' => LeadStatus::class,
        'utm_json' => 'array',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['status'])->logOnlyDirty();
    }
}
