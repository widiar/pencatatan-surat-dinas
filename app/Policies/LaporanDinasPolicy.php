<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LaporanDinasPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function view(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'dinas_view')->count() > 0) return true;
    }

    public function create(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'dinas_add')->count() > 0) return true;
    }

    public function edit(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'dinas_edit')->count() > 0) return true;
    }

    public function delete(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'dinas_delete')->count() > 0) return true;
    }
}
