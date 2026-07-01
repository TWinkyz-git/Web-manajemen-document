@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div style="margin-bottom: 40px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; padding-bottom: 20px; border-bottom: 3px solid #000; color: #000;">Dashboard</h2>
</div>

{{-- Stats --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 48px;">
    <div style="border: 3px solid #000; padding: 32px 24px; background: #fff;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Total Documents</p>
        <p style="font-size: 48px; font-weight: 900; line-height: 1; color: #000;">{{ $totalDocuments }}</p>
    </div>
    <div style="border: 3px solid #000; padding: 32px 24px; background: #fff;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Total Categories</p>
        <p style="font-size: 48px; font-weight: 900; line-height: 1; color: #000;">{{ $totalCategories }}</p>
    </div>
    <div style="border: 3px solid #000000; padding: 32px 24px; background: #FFF8F0;">
        <p style="font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: #666; margin-bottom: 12px;">Welcome Back</p>
        <p style="font-size: 24px; font-weight: 900; line-height: 1; color: #000;">{{ auth()->user()->name }}</p>
    </div>
</div>

{{-- Recent Documents --}}
<div>
    <h3 style="font-size: 16px; font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 24px; padding-bottom: 12px; border-bottom: 3px solid #000;">Recent Documents</h3>
    @forelse ($recentDocuments as $document)
        <div style="padding: 16px 0; border-bottom: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <p style="font-weight: 700; margin-bottom: 4px; color: #000;">
                    <a href="{{ route('documents.show', $document) }}" style="color: #000000; text-decoration: none;">
                        {{ $document->title }}
                    </a>
                </p>
                <p style="font-size: 12px; color: #666;">{{ $document->category->name }} • {{ $document->created_at->diffForHumans() }}</p>
            </div>
            <span style="font-size: 11px; font-weight: 700; padding: 4px 8px; border: 2px solid #000; text-transform: uppercase; color: #000;">{{ strtoupper($document->file_type) }}</span>
        </div>
    @empty
        <p style="color: #666;">No documents yet. <a href="{{ route('documents.create') }}" style="color: #FF8C00;">Upload one!</a></p>
    @endforelse
</div>
@endsection