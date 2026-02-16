<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Lead extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'estimated_budget' => 'decimal:2',
            'follow_up_date' => 'date',
        ];
    }

    // ── Auto-number generation ──

    protected static function booted(): void
    {
        static::creating(function (Lead $lead) {
            if (empty($lead->lead_number)) {
                $lastNumber = static::withTrashed()->max('id') ?? 0;
                $lead->lead_number = 'LD-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ── Relationships ──

    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function siteVisits()
    {
        return $this->hasMany(SiteVisit::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('documents');
        $this->addMediaCollection('images');
    }

    // ── Scopes ──

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopePriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeWon($query)
    {
        return $query->where('status', 'won');
    }

    public function scopeLost($query)
    {
        return $query->where('status', 'lost');
    }

    public function scopeFollowUpDue($query)
    {
        return $query->whereNotNull('follow_up_date')
            ->where('follow_up_date', '<=', now())
            ->whereNotIn('status', ['won', 'lost']);
    }
}
