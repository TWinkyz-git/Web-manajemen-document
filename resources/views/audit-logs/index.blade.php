@extends('layouts.app')

@section('title', 'Audit Logs')

@section('content')
<div style="margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase;">Audit Logs</h2>
</div>

{{-- Filter --}}
<form method="GET" action="{{ route('audit-logs.index') }}" style="display: flex; gap: 16px; margin-bottom: 32px;">
    <select name="action" style="padding: 10px 16px; border: 3px solid #fff; background: #000; color: #fff; font-size: 14px; font-weight: 700; cursor: pointer;">
        <option value="">All Actions</option>
        @foreach ($actions as $action)
            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                {{ strtoupper(str_replace('_', ' ', $action)) }}
            </option>
        @endforeach
    </select>

    <input type="date" name="date" value="{{ request('date') }}" style="padding: 10px 16px; border: 3px solid #fff; background: #000; color: #fff; font-size: 14px;">

    <button type="submit" class="btn">Filter</button>
    <a href="{{ route('audit-logs.index') }}" class="btn btn-secondary">Reset</a>
</form>

{{-- Logs Table --}}
@if ($logs->count() > 0)
    <div style="border: 3px solid #fff; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 3px solid #fff; background: #fff; color: #000;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Action</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Document</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">IP Address</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 11px; text-transform: uppercase; letter-spacing: 1px;">Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    @php
                        $actionColor = match($log->action) {
                            'upload_document' => '#00ff00',
                            'delete_document' => '#ff0000',
                            'download_document' => '#ffff00',
                            'update_document' => '#00aaff',
                            default => '#fff',
                        };
                        $actionIcon = match($log->action) {
                            'upload_document' => '↑',
                            'delete_document' => '✕',
                            'download_document' => '↓',
                            'update_document' => '✎',
                            default => '•',
                        };
                    @endphp
                    <tr style="border-bottom: 1px solid #333;">
                        <td style="padding: 16px; font-weight: 700;">
                            <span style="color: {{ $actionColor }}; margin-right: 8px; font-size: 18px;">{{ $actionIcon }}</span>
                            <span style="font-size: 13px; text-transform: uppercase;">{{ str_replace('_', ' ', $log->action) }}</span>
                        </td>
                        <td style="padding: 16px; font-size: 14px; color: #888;">
                            {{ $log->document ? $log->document->title : '-' }}
                        </td>
                        <td style="padding: 16px; font-size: 13px; color: #666; font-family: monospace;">
                            {{ $log->ip_address }}
                        </td>
                        <td style="padding: 16px; font-size: 13px; color: #666;">
                            {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 24px;">
        {{ $logs->links() }}
    </div>
@else
    <div style="border: 3px dashed #666; padding: 60px 24px; text-align: center;">
        <p style="font-size: 18px; color: #888;">No activity logs yet.</p>
    </div>
@endif
@endsection