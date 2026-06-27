@extends('layouts.app')

@section('title', $team->name)

@section('content')
<div style="max-width: 1000px;">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 40px; border-bottom: 3px solid #fff; padding-bottom: 20px;">
        <div>
            <h2 style="font-size: 28px; font-weight: 900; text-transform: uppercase; margin-bottom: 12px;">{{ $team->name }}</h2>
            <p style="color: #888; font-size: 14px;">Created by <strong>{{ $team->creator->name }}</strong></p>
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            @if (auth()->id() === $team->created_by)
                <a href="{{ route('teams.edit', $team) }}" class="btn" style="font-size: 12px; padding: 10px 16px; white-space: nowrap;">✎ Edit</a>
                <form method="POST" action="{{ route('teams.destroy', $team) }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="width: 100%; font-size: 12px; padding: 10px 16px; background: #ff0000; border-color: #ff0000; color: #000; font-weight: 900;" onclick="return confirm('Are you sure?')">🗑 Delete</button>
                </form>
            @endif
        </div>
    </div>

    @if (session('success'))
        <div style="background: #E8F5E9; border: 3px solid #4CAF50; color: #4CAF50; padding: 12px; margin-bottom: 24px; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="background: #FFEBEE; border: 3px solid #D32F2F; color: #D32F2F; padding: 12px; margin-bottom: 24px; font-weight: 600;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; gap: 32px; margin-bottom: 40px;">
        <div>
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 16px;">Description</h3>
            <p style="font-size: 16px; line-height: 1.8;">{{ $team->description ?: 'No description provided' }}</p>
        </div>

        <div style="border: 3px solid #fff; padding: 24px;">
            <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #666; margin-bottom: 24px;">Members ({{ $team->members()->count() }})</h3>
            
            @if ($members->count())
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 3px solid #fff;">
                                <th style="text-align: left; padding: 12px 0; font-weight: 900; text-transform: uppercase; font-size: 11px;">Name</th>
                                <th style="text-align: left; padding: 12px 0; font-weight: 900; text-transform: uppercase; font-size: 11px;">Email</th>
                                <th style="text-align: left; padding: 12px 0; font-weight: 900; text-transform: uppercase; font-size: 11px;">Role</th>
                                @if (auth()->id() === $team->created_by || auth()->user()->teamMemberships()->where('team_id', $team->id)->where('role', 'leader')->exists())
                                    <th style="text-align: left; padding: 12px 0; font-weight: 900; text-transform: uppercase; font-size: 11px;">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                                <tr style="border-bottom: 1px solid #444;">
                                    <td style="padding: 12px 0;">{{ $member->user->name }}</td>
                                    <td style="padding: 12px 0;">{{ $member->user->email }}</td>
                                    <td style="padding: 12px 0;">
                                        <span style="background: @if($member->role === 'leader')#FF8C00@else#888@endif; color: #fff; padding: 4px 12px; font-size: 10px; font-weight: 700; text-transform: uppercase;">{{ $member->role }}</span>
                                    </td>
                                    @if (auth()->id() === $team->created_by || auth()->user()->teamMemberships()->where('team_id', $team->id)->where('role', 'leader')->exists())
                                        <td style="padding: 12px 0;">
                                            <form method="POST" action="{{ route('teams.updateMemberRole', [$team, $member]) }}" style="display: inline-flex; gap: 8px; align-items: center;">
                                                @csrf
                                                @method('PATCH')
                                                <select name="role" style="padding: 6px; border: 2px solid #fff; background: transparent; color: #fff; font-weight: 700; font-size: 11px;">
                                                    <option value="member" @selected($member->role === 'member')>Member</option>
                                                    <option value="leader" @selected($member->role === 'leader')>Leader</option>
                                                </select>
                                                <button type="submit" style="padding: 6px 12px; background: #fff; color: #000; border: none; font-weight: 700; font-size: 10px; cursor: pointer; text-transform: uppercase;">Update</button>
                                            </form>
                                            <form method="POST" action="{{ route('teams.removeMember', [$team, $member]) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" style="padding: 6px 12px; background: #ff0000; color: #000; border: none; font-weight: 700; font-size: 10px; cursor: pointer; text-transform: uppercase; margin-left: 8px;" onclick="return confirm('Are you sure?')">Remove</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $members->links() }}
            @else
                <p style="color: #888; text-align: center; padding: 20px;">No members yet.</p>
            @endif
        </div>

        @if (auth()->id() === $team->created_by || auth()->user()->teamMemberships()->where('team_id', $team->id)->where('role', 'leader')->exists())
            <div style="border: 3px solid #FF8C00; padding: 24px;">
                <h3 style="font-weight: 900; text-transform: uppercase; font-size: 12px; letter-spacing: 1px; color: #FF8C00; margin-bottom: 16px;">Add Member</h3>
                
                <form method="POST" action="{{ route('teams.addMember', $team) }}" style="display: grid; gap: 16px;">
                    @csrf

                    <div>
                        <label for="user_id" style="display: block; font-weight: 700; text-transform: uppercase; font-size: 11px; margin-bottom: 8px;">Select User</label>
                        <select id="user_id" name="user_id" required style="width: 100%; padding: 10px; border: 2px solid #FF8C00; background: transparent; color: #fff; font-weight: 600;">
                            <option value="">-- Choose User --</option>
                            @foreach (\App\Models\User::all() as $user)
                                @if (!$team->members()->where('user_id', $user->id)->exists())
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="role" style="display: block; font-weight: 700; text-transform: uppercase; font-size: 11px; margin-bottom: 8px;">Role</label>
                        <select id="role" name="role" required style="width: 100%; padding: 10px; border: 2px solid #FF8C00; background: transparent; color: #fff; font-weight: 600;">
                            <option value="member">Member</option>
                            <option value="leader">Leader</option>
                        </select>
                    </div>

                    <button type="submit" class="btn" style="background: #FF8C00; border-color: #FF8C00;">Add Member</button>
                </form>
            </div>
        @endif
    </div>

    <div style="display: flex; gap: 12px;">
        <a href="{{ route('teams.index') }}" class="btn btn-secondary" style="flex: 1;">← Back to Teams</a>
    </div>
</div>

@endsection