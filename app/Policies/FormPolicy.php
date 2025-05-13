<?php

namespace App\Policies;

use App\Models\Form;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FormPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Form $form): bool
    {
        return $user->id === $form->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Form $form): bool
    {
        return $user->id === $form->user_id;
    }

    public function delete(User $user, Form $form): bool
    {
        return $user->id === $form->user_id;
    }

    public function viewLeads(User $user, Form $form): bool
    {
        return $user->id === $form->user_id;
    }

    public function deleteLeads(User $user, Form $form): bool
    {
        return $user->id === $form->user_id;
    }
}