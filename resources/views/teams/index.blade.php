@extends('layouts.app')

@section('title', 'Teams')

@section('content')
<div style="max-width: 1200px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 12px;">Teams</h2>
            <p style="color: #888; font-size: 14px;">Manage and collaborate with your teams</p>
        </div>
        <a href="{{ route('teams.create') }}" class="btn" style="font-size: 12px; padding: 10px 16px;">➕ Create Team</a>
    </div>

    @if (session('success'))
        <div style="background: #E8F5E9; border: 3px solid #4CAF50; color: #4CAF50; padding: 12px; margin-bottom: 24px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; gap: 40px; margin-bottom: 60px;">
        <div>
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 24px;">Your Teams</h3>
            
            @if ($ownedTeams->count())
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    @foreach ($ownedTeams as $team)
                        <div style="border: 3px solid #fff; padding: 24px;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                                <div>
                                    <h4 style="font-size: 18px; font-weight: 900; margin-bottom: 4px;">{{ $team->name }}</h4>
                                    <p style="color: #666; font-size: 12px;">{{ $team->members()->count() }} members</p>
                                </div>
                                <span style="background: #FF8C00; color: #000; padding: 4px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase;">LEADER</span>
                            </div>
                            
                            <p style="color: #888; font-size: 13px; margin-bottom: 20px; line-height: 1.5;">
                                {{ $team->description ?: 'No description' }}
                            </p>
                            
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('teams.show', $team) }}" class="btn" style="flex: 1; font-size: 11px; padding: 8px 12px;">View</a>
                                <a href="{{ route('teams.edit', $team) }}" class="btn" style="flex: 1; font-size: 11px; padding: 8px 12px;">Edit</a>
                                <form method="POST" action="{{ route('teams.destroy', $team) }}" style="flex: 1;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="width: 100%; font-size: 11px; padding: 8px 12px; background: #ff0000; border-color: #ff0000; color: #000; font-weight: 900;" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{ $ownedTeams->links() }}
            @else
                <p style="color: #888; text-align: center; padding: 40px;">You haven't created any teams yet.</p>
            @endif
        </div>

        <div>
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 24px;">Teams You Joined</h3>
            
            @if ($joinedTeams->count())
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px;">
                    @foreach ($joinedTeams as $team)
                        <div style="border: 3px solid #fff; padding: 24px;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 16px;">
                                <div>
                                    <h4 style="font-size: 18px; font-weight: 900; margin-bottom: 4px;">{{ $team->name }}</h4>
                                    <p style="color: #666; font-size: 12px;">{{ $team->members()->count() }} members</p>
                                </div>
                                <span style="background: #888; color: #fff; padding: 4px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase;">{{ auth()->user()->teamMemberships()->where('team_id', $team->id)->first()->role }}</span>
                            </div>
                            
                            <p style="color: #888; font-size: 13px; margin-bottom: 20px; line-height: 1.5;">
                                {{ $team->description ?: 'No description' }}
                            </p>
                            
                            <a href="{{ route('teams.show', $team) }}" class="btn" style="width: 100%; font-size: 11px; padding: 8px 12px;">View Team</a>
                        </div>
                    @endforeach
                </div>
                {{ $joinedTeams->links() }}
            @else
                <p style="color: #888; text-align: center; padding: 40px;">You haven't joined any teams yet.</p>
            @endif
        </div>
    </div>

    <div style="display: flex; gap: 12px;">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary" style="flex: 1;">← Back to Dashboard</a>
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