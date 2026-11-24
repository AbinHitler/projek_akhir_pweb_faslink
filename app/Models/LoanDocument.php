<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoanDocument extends Model
{
    protected $fillable = ['loan_id', 'original_name', 'file_path', 'mime_type', 'file_size'];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
