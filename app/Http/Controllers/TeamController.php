<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Services\AuditLogService;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TeamController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $ownedTeams = auth()->user()->ownedTeams()->paginate(10);
        $joinedTeams = auth()->user()->teams()->paginate(10);
        
        return view('teams.index', compact('ownedTeams', 'joinedTeams'));
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'created_by' => auth()->id(),
        ]);

        // Add creator as leader
        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => auth()->id(),
            'role' => 'leader',
        ]);

        AuditLogService::log(
            action: 'create_team',
            documentId: null,
            metadata: ['team_name' => $team->name]
        );

        return redirect()->route('teams.show', $team)->with('success', 'Team created successfully!');
    }

    public function show(Team $team)
    {
        $this->authorize('view', $team);
        
        $members = $team->members()->with('user')->paginate(10);
        
        return view('teams.show', compact('team', 'members'));
    }

    public function edit(Team $team)
    {
        $this->authorize('update', $team);
        
        return view('teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $team->update($validated);

        AuditLogService::log(
            action: 'update_team',
            documentId: null,
            metadata: ['team_id' => $team->id]
        );

        return redirect()->route('teams.show', $team)->with('success', 'Team updated successfully!');
    }

    public function destroy(Team $team)
    {
        $this->authorize('delete', $team);

        $team->delete();

        AuditLogService::log(
            action: 'delete_team',
            documentId: null,
            metadata: ['team_id' => $team->id]
        );

        return redirect()->route('teams.index')->with('success', 'Team deleted successfully!');
    }

    public function addMember(Request $request, Team $team)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:leader,member',
        ]);

        // Check if already member
        if ($team->members()->where('user_id', $validated['user_id'])->exists()) {
            return back()->with('error', 'User is already a team member!');
        }

        TeamMember::create([
            'team_id' => $team->id,
            'user_id' => $validated['user_id'],
            'role' => $validated['role'],
        ]);

        AuditLogService::log(
            action: 'add_team_member',
            documentId: null,
            metadata: ['team_id' => $team->id, 'user_id' => $validated['user_id']]
        );

        return back()->with('success', 'Member added successfully!');
    }

    public function removeMember(Team $team, TeamMember $member)
    {
        $this->authorize('update', $team);

        // Don't allow removing last leader
        $leaderCount = $team->members()->where('role', 'leader')->count();
        if ($member->role === 'leader' && $leaderCount === 1) {
            return back()->with('error', 'Cannot remove the last team leader!');
        }

        $member->delete();

        AuditLogService::log(
            action: 'remove_team_member',
            documentId: null,
            metadata: ['team_id' => $team->id, 'user_id' => $member->user_id]
        );

        return back()->with('success', 'Member removed successfully!');
    }

    public function updateMemberRole(Request $request, Team $team, TeamMember $member)
    {
        $this->authorize('update', $team);

        $validated = $request->validate([
            'role' => 'required|in:leader,member',
        ]);

        // Don't allow removing last leader
        if ($member->role === 'leader' && $validated['role'] === 'member') {
            $leaderCount = $team->members()->where('role', 'leader')->count();
            if ($leaderCount === 1) {
                return back()->with('error', 'Cannot remove the last team leader!');
            }
        }

        $member->update(['role' => $validated['role']]);

        AuditLogService::log(
            action: 'update_team_member_role',
            documentId: null,
            metadata: ['team_id' => $team->id, 'user_id' => $member->user_id, 'role' => $validated['role']]
        );

        return back()->with('success', 'Member role updated successfully!');
    }
}