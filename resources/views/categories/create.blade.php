@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div style="max-width: 600px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 40px; padding-bottom: 20px; border-bottom: 3px solid #fff;">New Category</h2>

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div style="margin-bottom: 32px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Name *</label>
            <input type="text" name="name" required style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px;" placeholder="Category name" value="{{ old('name') }}">
            @error('name')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="margin-bottom: 40px;">
            <label style="display: block; font-weight: 700; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 8px;">Description</label>
            <textarea name="description" style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px; font-family: inherit;" placeholder="Optional description" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #ff0000; font-size: 12px; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn" style="flex: 1;">Create</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary" style="flex: 1; text-align: center;">Cancel</a>
        </div>
    </form>
</div>
@endsection