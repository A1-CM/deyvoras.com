<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractObligation extends Model
{
    protected $fillable = ['assigned_to_user_id', 'title', 'description', 'responsible_name', 'due_at', 'status'];

    protected function casts(): array
    {
        return ['due_at' => 'date'];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }
}
