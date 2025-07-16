<?php

namespace App\Policies;

use App\Models\User;

class TrashPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageTrash(User $user)
    {
        return $user->is_admin; // Ou sua lógica de permissão
    }
}
