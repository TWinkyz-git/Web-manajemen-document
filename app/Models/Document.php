<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'encryption_key',
        'status',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Relasi ke User (many-to-one)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Category (many-to-one)
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi ke DocumentPermission
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(DocumentPermission::class);
    }

    /**
     * Relasi ke AuditLog
     */
    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class);
    }
}