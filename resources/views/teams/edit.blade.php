@extends('layouts.app')

@section('title', 'Edit Team')

@section('content')
<div style="max-width: 600px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 12px;">Edit Team</h2>
            <p style="color: #888; font-size: 14px;">Update team information</p>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: #FFEBEE; border: 3px solid #D32F2F; color: #D32F2F; padding: 12px; margin-bottom: 24px; font-weight: 600;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('teams.update', $team) }}" style="display: grid; gap: 24px;">
        @csrf
        @method('PATCH')

        <div>
            <label for="name" style="display: block; font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 12px; color: #fff;">Team Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $team->name) }}" required placeholder="Team Name" style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px;">
            @error('name')
                <div style="color: #D32F2F; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="description" style="display: block; font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; margin-bottom: 12px; color: #fff;">Description</label>
            <textarea id="description" name="description" placeholder="Team description" style="width: 100%; padding: 12px; border: 3px solid #fff; background: transparent; color: #fff; font-size: 16px; min-height: 120px; font-family: inherit;">{{ old('description', $team->description) }}</textarea>
            @error('description')
                <div style="color: #D32F2F; font-size: 11px; margin-top: 4px; font-weight: 700;">{{ $message }}</div>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn" style="flex: 1;">Update Team</button>
            <a href="{{ route('teams.show', $team) }}" class="btn btn-secondary" style="flex: 1;">Cancel</a>
        </div>
    </form>
</div>

@endsection