<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Project extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'expected_end_date' => 'date',
            'actual_end_date' => 'date',
            'total_value' => 'decimal:2',
            'progress_percentage' => 'integer',
        ];
    }

    // ── Auto-number generation ──

    protected static function booted(): void
    {
        static::creating(function (Project $project) {
            if (empty($project->project_number)) {
                $lastNumber = static::withTrashed()->max('id') ?? 0;
                $project->project_number = 'PJ-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ── Relationships ──

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'project_manager');
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class)->orderBy('sort_order');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('project_photos');
        $this->addMediaCollection('documents');
    }

    // ── Helper Methods ──

    public function totalPaid(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function balanceDue(): float
    {
        return (float) $this->total_value - $this->totalPaid();
    }

    public function updateProgress(): void
    {
        $totalTasks = $this->tasks()->count();
        if ($totalTasks === 0) {
            return;
        }
        $completedTasks = $this->tasks()->where('status', 'completed')->count();
        $this->progress_percentage = (int) round(($completedTasks / $totalTasks) * 100);
        $this->saveQuietly();
    }

    // ── Scopes ──

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['not_started', 'in_progress']);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
