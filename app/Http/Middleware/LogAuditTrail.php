<?php

namespace App\Http\Middleware;

use App\Services\AuditLogService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogAuditTrail
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Catat hanya request yang mengubah data (POST, PUT, DELETE)
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE']) && auth()->check()) {
            $action = match($request->method()) {
                'POST' => 'create',
                'PUT' => 'update',
                'DELETE' => 'delete',
                default => 'unknown',
            };

            AuditLogService::log(
                action: $action,
                metadata: [
                    'route' => $request->route()?->getName(),
                    'method' => $request->method(),
                ]
            );
        }

        return $response;
    }
}