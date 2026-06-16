<?php

namespace App\Services;

use App\Models\AuditLog;

class AuditLogService
{
    public static function log(
        string $action,
        ?int $documentId = null,
        ?array $metadata = null
    ): void {
        AuditLog::create([
            'user_id' => auth()->id(),
            'document_id' => $documentId,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}