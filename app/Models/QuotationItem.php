<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'rate' => 'decimal:2',
            'amount' => 'decimal:2',
            'gst_percentage' => 'decimal:2',
            'gst_amount' => 'decimal:2',
        ];
    }

    // ── Auto-calculate on save ──

    protected static function booted(): void
    {
        static::saving(function (QuotationItem $item) {
            $item->amount = round($item->quantity * $item->rate, 2);
            $item->gst_amount = round($item->amount * $item->gst_percentage / 100, 2);
        });
    }

    // ── Relationships ──

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
