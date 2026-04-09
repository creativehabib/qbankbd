<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class QuestionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('questions.read');
    }

    public function view(User $user, Question $question): bool
    {
        if (! $user->hasPermission('questions.read')) {
            return false;
        }

        if ($user->isTeacher()) {
            return (int) $question->user_id === (int) $user->id;
        }

        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission('questions.create');
    }

    public function update(User $user, Question $question): bool
    {
        if (! $user->hasPermission('questions.update')) {
            return false;
        }

        if ($user->isTeacher()) {
            return (int) $question->user_id === (int) $user->id;
        }

        return true;
    }

    public function delete(User $user, Question $question): bool
    {
        if (! $user->hasPermission('questions.delete')) {
            return false;
        }

        if ($user->isTeacher()) {
            return (int) $question->user_id === (int) $user->id;
        }

        return true;
    }
}
