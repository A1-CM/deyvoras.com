<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    protected $fillable = [
        'organization_id', 'created_by', 'title', 'document_type', 'counterparty',
        'contract_number', 'effective_date', 'expiry_date', 'notice_days', 'status',
        'review_status', 'summary', 'document_path', 'document_name',
    ];

    protected function casts(): array
    {
        return [
            'effective_date' => 'date',
            'expiry_date' => 'date',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function clauses(): HasMany
    {
        return $this->hasMany(ContractClause::class);
    }

    public function obligations(): HasMany
    {
        return $this->hasMany(ContractObligation::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ContractActivity::class);
    }

    public function documentVersions(): HasMany
    {
        return $this->hasMany(ContractDocumentVersion::class)->orderByDesc('version_number');
    }
}
