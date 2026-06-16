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
        return $document->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the document.
     */
    public function delete(User $user, Document $document): bool
    {
        return $document->user_id === $user->id;
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

        // Shared user dengan permission download
        return $document->permissions()
            ->where('user_id', $user->id)
            ->where('permission', 'download')
            ->exists();
    }
}