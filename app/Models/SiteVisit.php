<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class SiteVisit extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'scheduled_date' => 'date',
            'scheduled_time' => 'datetime:H:i',
            'measurements' => 'array',
            'photos' => 'array',
            'completed_at' => 'datetime',
        ];
    }

    // ── Auto-number generation ──

    protected static function booted(): void
    {
        static::creating(function (SiteVisit $visit) {
            if (empty($visit->visit_number)) {
                $lastNumber = static::withTrashed()->max('id') ?? 0;
                $visit->visit_number = 'SV-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ── Relationships ──

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('site_photos');
        $this->addMediaCollection('documents');
    }

    // ── Scopes ──

    public function scopeScheduled($query)
    {
        return $query->where('visit_status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('visit_status', 'completed');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('visit_status', 'scheduled')
            ->where('scheduled_date', '>=', now()->toDateString())
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time');
    }
}
