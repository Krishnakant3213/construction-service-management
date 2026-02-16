<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quotation extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'quotation_date' => 'date',
            'valid_until' => 'date',
            'subtotal' => 'decimal:2',
            'discount_value' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'taxable_amount' => 'decimal:2',
            'cgst_amount' => 'decimal:2',
            'sgst_amount' => 'decimal:2',
            'igst_amount' => 'decimal:2',
            'total_tax' => 'decimal:2',
            'grand_total' => 'decimal:2',
            'approved_at' => 'datetime',
            'rejected_at' => 'datetime',
        ];
    }

    // ── Auto-number generation (with date string) ──

    protected static function booted(): void
    {
        static::creating(function (Quotation $quotation) {
            if (empty($quotation->quotation_number)) {
                $dateStr = now()->format('Ymd');
                $todayCount = static::withTrashed()
                    ->where('quotation_number', 'like', "QT-{$dateStr}-%")
                    ->count();
                $quotation->quotation_number = 'QT-' . $dateStr . '-' . str_pad($todayCount + 1, 5, '0', STR_PAD_LEFT);
            }
        });
    }

    // ── Relationships ──

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function preparedByUser()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class)->orderBy('sort_order');
    }

    public function project()
    {
        return $this->hasOne(Project::class);
    }

    public function parentQuotation()
    {
        return $this->belongsTo(Quotation::class, 'parent_quotation_id');
    }

    public function revisions()
    {
        return $this->hasMany(Quotation::class, 'parent_quotation_id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('quotation_pdf')->singleFile();
        $this->addMediaCollection('documents');
    }

    // ── Tax Calculation Methods ──

    public function calculateTotals(): void
    {
        $this->subtotal = $this->items->sum('amount');

        // Calculate discount
        if ($this->discount_type === 'percentage' && $this->discount_value > 0) {
            $this->discount_amount = round($this->subtotal * $this->discount_value / 100, 2);
        } elseif ($this->discount_type === 'fixed' && $this->discount_value > 0) {
            $this->discount_amount = $this->discount_value;
        } else {
            $this->discount_amount = 0;
        }

        $this->taxable_amount = $this->subtotal - $this->discount_amount;

        // Calculate GST from line items
        $totalGst = $this->items->sum('gst_amount');

        // Determine GST split (CGST+SGST for intra-state, IGST for inter-state)
        // Default: intra-state (can be toggled based on business logic)
        $this->cgst_amount = round($totalGst / 2, 2);
        $this->sgst_amount = round($totalGst / 2, 2);
        $this->igst_amount = 0;

        $this->total_tax = $totalGst;
        $this->grand_total = $this->taxable_amount + $this->total_tax;
    }

    // ── Scopes ──

    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', '!=', 'approved')
            ->where('valid_until', '<', now()->toDateString());
    }
}
