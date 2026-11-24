<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    protected $fillable = [
        'code', 'user_id', 'activity_name', 'organization', 'description',
        'responsible_name', 'responsible_contact', 'participant_count',
        'start_at', 'end_at', 'facility_name', 'quantity', 'additional_notes',
        'status', 'rejection_note', 'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'cancelled_at' => 'datetime',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LoanDocument::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
