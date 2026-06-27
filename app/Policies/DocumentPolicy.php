<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine if the user can view the document.
     */
    public function view(User $user, Document $document): bool
    {
        // Owner bisa view
        if ($document->user_id === $user->id) {
            return true;
        }

        // Jika document punya team, hanya team members bisa view
        if ($document->team_id) {
            return $document->team->members()
                ->where('user_id', $user->id)
                ->exists();
        }

        // Shared user bisa view jika punya permission
        return $document->permissions()
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine if the user can update the document.
     */
    public function update(User $user, Document $document): bool
    {
        // Owner bisa update
        if ($document->user_id === $user->id) {
            return true;
        }

        // Jika document punya team, hanya team leader bisa update
        if ($document->team_id) {
            return $document->team->members()
                ->where('user_id', $user->id)
                ->where('role', 'leader')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can delete the document.
     */
    public function delete(User $user, Document $document): bool
    {
        // Owner bisa delete
        if ($document->user_id === $user->id) {
            return true;
        }

        // Jika document punya team, hanya team leader bisa delete
        if ($document->team_id) {
            return $document->team->members()
                ->where('user_id', $user->id)
                ->where('role', 'leader')
                ->exists();
        }

        return false;
    }

    /**
     * Determine if the user can download the document.
     */
    public function download(User $user, Document $document): bool
    {
        // Owner bisa download
        if ($document->user_id === $user->id) {
            return true;
        }

        // Jika document punya team, team members bisa download
        if ($document->team_id) {
            return $document->team->members()
                ->where('user_id', $user->id)
                ->exists();
        }

        // Shared user dengan permission download
        return $document->permissions()
            ->where('user_id', $user->id)
            ->where('permission', 'download')
            ->exists();
    }
}