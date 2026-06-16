@extends('layouts.app')

@section('title', 'Edit Document')

@section('content')
<div style="max-width: 600px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #fff;">Edit Document</h2>

    <form method="POST" action="{{ route('documents.update', $document) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Title *</label>
            <input type="text" name="title" required style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px;" value="{{ old('title', $document->title) }}">
            @error('title')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Description</label>
            <textarea name="description" style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px; font-family: inherit;" rows="4">{{ old('description', $document->description) }}</textarea>
            @error('description')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Category *</label>
            <select name="category_id" required style="width: 100%; padding: 12px; border: 3px solid #fff; background: #000; color: #fff; font-size: 16px; cursor: pointer;">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $document->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 40px; padding: 20px; border: 1px solid #666; background: #111;">
            <p style="font-size: 12px; color: #666; margin-bottom: 8px;">CURRENT FILE</p>
            <p style="font-weight: 700; margin-bottom: 8px;">{{ $document->file_name }}</p>
            <p style="font-size: 12px; color: #666;">{{ formatBytes($document->file_size) }} • {{ strtoupper($document->file_type) }}</p>
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn" style="flex: 1;">Update</button>
            <a href="{{ route('documents.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">Cancel</a>
        </div>
    </form>
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