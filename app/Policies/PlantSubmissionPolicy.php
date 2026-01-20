<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PlantSubmission;

class PlantSubmissionPolicy
{
    public function update(User $user, PlantSubmission $submission)
    {
        // Uploader bisa edit, member lain bisa edit jika uploader_approval = true, admin selalu bisa edit
        return $user->is_admin || $user->id === $submission->uploader_id || $submission->uploader_approval;
    }

    public function review(User $user, PlantSubmission $submission)
    {
        // Hanya admin (is_admin = true) yang bisa review
        return $user->is_admin;
    }
}
