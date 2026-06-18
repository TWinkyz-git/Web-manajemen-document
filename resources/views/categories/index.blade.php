@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
    <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase;">Categories</h2>
    @if(auth()->user()->hasRole('admin'))
        <a href="{{ route('categories.create') }}" class="btn">+ New Category</a>
    @endif
</div>

@if ($categories->count() > 0)
    <div style="display: grid; gap: 16px;">
        @foreach ($categories as $category)
            <div style="border: 3px solid #fff; padding: 24px; display: grid; grid-template-columns: 1fr auto; gap: 20px; align-items: center;">
                <div>
                    <h3 style="font-size: 18px; font-weight: 900; text-transform: uppercase; margin-bottom: 8px;">{{ $category->name }}</h3>
                    <p style="color: #888; font-size: 14px; margin-bottom: 8px;">{{ $category->description ?: 'No description' }}</p>
                    <span style="font-size: 12px; color: #666; font-weight: 700;">{{ $category->documents_count }} document(s)</span>
                </div>
                @if(auth()->user()->hasRole('admin'))
                    <div style="display: flex; gap: 8px;">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;">Edit</a>
                        <form method="POST" action="{{ route('categories.destroy', $category) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-secondary" style="font-size: 12px; padding: 8px 16px;" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
@else
    <div style="border: 3px dashed #666; padding: 60px 24px; text-align: center;">
        <p style="font-size: 18px; color: #888; margin-bottom: 20px;">No categories yet</p>
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('categories.create') }}" class="btn">Create First Category</a>
        @endif
    </div>
@endif
@endsection