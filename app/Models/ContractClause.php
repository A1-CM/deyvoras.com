<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractClause extends Model
{
    protected $fillable = ['category', 'title', 'excerpt', 'notes', 'verification_status'];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}
