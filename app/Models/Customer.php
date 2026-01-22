<?php

namespace App\Models;

use App\Enums\CustomerStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    protected $fillable = [
        'branch_id',
        'created_by',
        'full_name',
        'status',
    ];

    protected $casts = [
        'status' => CustomerStatus::class,
    ];

    /* =========================
     | Relationships
     ========================= */

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function audits(): HasMany
    {
        return $this->hasMany(CustomerAudit::class);
    }

    public function idDetail(): HasOne
    {
        return $this->hasOne(CustomerIdDetail::class);
    }

    public function coMaker(): HasOne
    {
        return $this->hasOne(CustomerCoMaker::class);
    }

    public function transaction(): HasOne
    {
        return $this->hasOne(CustomerTransaction::class);
    }

    public function financial(): HasOne
    {
        return $this->hasOne(CustomerFinancial::class);
    }

    /* =========================
     | Helpers
     ========================= */

    public function isArchived(): bool
    {
        return $this->status === CustomerStatus::ARCHIVED;
    }
}
