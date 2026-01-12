<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\BranchStatus;
use App\Models\User;


class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'status',
        'archived_at',
        'archived_by',
    ];

    protected $casts = [
        'status'      => BranchStatus::class,
        'archived_at' => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    /* =========================
     |  Relationships
     ========================= */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function archivedBy()
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    /* =========================
     |  Helpers
     ========================= */
    public function isArchived(): bool
    {
        return $this->status === BranchStatus::ARCHIVED;
    }
}
