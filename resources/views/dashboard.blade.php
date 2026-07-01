@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 40px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; padding-bottom: 20px; border-bottom: 3px solid #000000;">Dashboard</h2>
</div>

{{-- Stats --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 48px;">
    <div style="border: 3px solid #000000; padding: 32px 24px;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Total Documents</p>
        <p style="font-size: 48px; font-weight: 900; line-height: 1;">{{ $totalDocuments }}</p>
    </div>
    <div style="border: 3px solid #000000; padding: 32px 24px;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Total Categories</p>
        <p style="font-size: 48px; font-weight: 900; line-height: 1;">{{ $totalCategories }}</p>
    </div>
    <div style="border: 3px solid #000000; padding: 32px 24px; background: #ffffff; color: #000;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Welcome Back</p>
        <p style="font-size: 24px; font-weight: 900; line-height: 1;">{{ auth()->user()->name }}</p>
    </div>
</div>

{{-- Recent Documents --}}
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
    <div>
        <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 3px solid #000000;">Recent Documents</h3>
        @forelse ($recentDocuments as $document)
            <div style="padding: 16px 0; border-bottom: 1px solid #333; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <p style="font-weight: 700; margin-bottom: 4px;">
                        <a href="{{ route('documents.show', $document) }}" style="color: #000000; text-decoration: none;">
                            {{ $document->title }}
                        </a>
                    </p>
                    <p style="font-size: 12px; color: #666;">{{ $document->category->name }} • {{ $document->created_at->diffForHumans() }}</p>
                </div>
                <span style="font-size: 11px; font-weight: 700; padding: 4px 8px; border: 2px solid #000000; text-transform: uppercase;">{{ strtoupper($document->file_type) }}</span>
            </div>
        @empty
            <p style="color: #666;">No documents yet. <a href="{{ route('documents.create') }}" style="color: #000000;">Upload one!</a></p>
        @endforelse
    </div>

    {{-- Recent Activity --}}
    <div>
        <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 3px solid #fff;">Recent Activity</h3>
        @forelse ($recentLogs as $log)
            <div style="padding: 16px 0; border-bottom: 1px solid #333;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        @php
                            $actionColor = match($log->action) {
                                'upload_document' => '#00ff00',
                                'delete_document' => '#ff0000',
                                'download_document' => '#ffff00',
                                'update_document' => '#00aaff',
                                default => '#000000',
                            };
                            $actionIcon = match($log->action) {
                                'upload_document' => '↑',
                                'delete_document' => '✕',
                                'download_document' => '↓',
                                'update_document' => '✎',
                                default => '•',
                            };
                        @endphp
                        <span style="color: {{ $actionColor }}; font-weight: 900; font-size: 18px;">{{ $actionIcon }}</span>
                        <div>
                            <p style="font-weight: 700; font-size: 13px; text-transform: uppercase;">{{ str_replace('_', ' ', $log->action) }}</p>
                            @if($log->document)
                                <p style="font-size: 12px; color: #666;">{{ $log->document->title }}</p>
                            @endif
                        </div>
                    </div>
                    <p style="font-size: 11px; color: #666;">{{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}</p>
                </div>
            </div>
        @empty
            <p style="color: #666;">No activity yet.</p>
        @endforelse
    </div>
</div>
@endsection