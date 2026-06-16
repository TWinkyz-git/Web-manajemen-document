@extends('layouts.app')

@section('title', 'Documents')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase;">My Documents</h2>
    <a href="{{ route('documents.create') }}" class="btn">+ Upload</a>
</div>

@if ($documents->count() > 0)
    <div style="display: grid; gap: 24px;">
        @foreach ($documents as $document)
            <div style="border: 3px solid #fff; padding: 24px; display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: start;">
                <div>
                    <h3 style="font-size: 20px; font-weight: 900; text-transform: uppercase; margin-bottom: 8px;">
                        <a href="{{ route('documents.show', $document) }}" style="color: #fff; text-decoration: none; border-bottom: 3px solid #fff;">
                            {{ $document->title }}
                        </a>
                    </h3>
                    <p style="color: #888; font-size: 14px; margin-bottom: 12px;">{{ $document->description }}</p>
                    <div style="display: flex; gap: 16px; font-size: 12px; color: #666;">
                        <span>📂 {{ $document->category->name }}</span>
                        <span>📄 {{ strtoupper($document->file_type) }}</span>
                        <span>📦 {{ formatBytes($document->file_size) }}</span>
                        <span>📅 {{ $document->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <a href="{{ route('documents.download', $document) }}" class="btn" style="font-size: 12px; padding: 10px 16px; text-align: center;">Download</a>
                    <a href="{{ route('documents.edit', $document) }}" class="btn btn-secondary" style="font-size: 12px; padding: 10px 16px; text-align: center;">Edit</a>
                    <form method="POST" action="{{ route('documents.destroy', $document) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary" style="width: 100%; font-size: 12px; padding: 10px 16px;">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div style="margin-top: 40px; display: flex; gap: 8px; justify-content: center;">
        {{ $documents->links() }}
    </div>
@else
    <div style="border: 3px dashed #666; padding: 60px 24px; text-align: center;">
        <p style="font-size: 18px; color: #888; margin-bottom: 20px;">No documents yet</p>
        <a href="{{ route('documents.create') }}" class="btn">Start Uploading</a>
    </div>
@endif

@php
function formatBytes($bytes, $precision = 2) {
    $units = ['B', 'KB', 'MB', 'GB'];
    for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
        $bytes /= 1024;
    }
    return round($bytes, $precision) . ' ' . $units[$i];
}
@endphp
@endsection