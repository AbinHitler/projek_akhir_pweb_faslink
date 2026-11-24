<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facility extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type', 'name', 'parent_id', 'category_id', 'location', 'capacity',
        'stock_total', 'stock_damaged', 'condition', 'status', 'responsible', 'description',
    ];

    protected function casts(): array
    {
        return ['capacity' => 'integer', 'stock_total' => 'integer', 'stock_damaged' => 'integer'];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->where('type', 'ruangan');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(FacilityCategory::class, 'category_id');
    }

    public function getAvailableStockAttribute(): ?int
    {
        return $this->type === 'barang'
            ? max(0, (int) $this->stock_total - (int) $this->stock_damaged)
            : null;
    }
}
