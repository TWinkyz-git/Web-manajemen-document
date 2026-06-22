@extends('layouts.app')

@section('title', $document->title)

@section('content')
<div style="max-width: 1000px;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 12px;">{{ $document->title }}</h2>
            <p style="color: #888; font-size: 14px;">Uploaded by <strong>{{ $document->user->name }}</strong> on {{ $document->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <a href="{{ route('documents.download', $document) }}" class="btn" style="font-size: 12px; padding: 10px 16px; white-space: nowrap;">📥 Download</a>
            <a href="{{ route('documents.edit', $document) }}" class="btn btn-secondary" style="font-size: 12px; padding: 10px 16px; white-space: nowrap;">✎ Edit</a>
        </div>
    </div>

    {{-- Preview Section --}}
    @if(in_array(strtolower($document->file_type), ['pdf', 'jpg', 'jpeg', 'png', 'gif']))
        <div style="border: 3px solid #fff; padding: 24px; margin-bottom: 32px; text-align: center;">
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 16px;">Preview</h3>
            <a href="{{ route('documents.preview', $document) }}" target="_blank" class="btn" style="font-size: 12px; padding: 10px 16px; display: inline-block;">👁 Open Preview</a>
        </div>
    @else
        <div style="border: 3px dashed #666; padding: 24px; margin-bottom: 32px; text-align: center;">
            <p style="color: #888;">Preview tidak tersedia untuk file type {{ strtoupper($document->file_type) }}</p>
            <p style="color: #666; font-size: 14px; margin-top: 8px;">Download file untuk melihat isinya</p>
        </div>
    @endif

    <div style="display: grid; gap: 32px;">
        <div>
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Description</h3>
            <p style="font-size: 16px; line-height: 1.8;">{{ $document->description ?: 'No description provided' }}</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; padding: 24px; border: 3px solid #fff;">
            <div>
                <p style="font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Category</p>
                <p style="font-size: 16px; font-weight: 700;">{{ $document->category->name }}</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">File Type</p>
                <p style="font-size: 16px; font-weight: 700;">{{ strtoupper($document->file_type) }}</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">File Size</p>
                <p style="font-size: 16px; font-weight: 700;">{{ formatBytes($document->file_size) }}</p>
            </div>
            <div>
                <p style="font-size: 12px; color: #666; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Status</p>
                <p style="font-size: 16px; font-weight: 700; text-transform: capitalize;">{{ $document->status }}</p>
            </div>
        </div>

        <div style="display: flex; gap: 12px;">
            <a href="{{ route('documents.index') }}" class="btn btn-secondary" style="flex: 1;">← Back to Documents</a>
            <form method="POST" action="{{ route('documents.destroy', $document) }}" style="flex: 1;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-secondary" style="width: 100%; background: #ff0000; border-color: #ff0000; color: #000; font-weight: 900;" onclick="return confirm('Are you sure?')">🗑 Delete</button>
            </form>
        </div>
    </div>
</div>

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