<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PencatatanSuratPolicy
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
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'surat_view')->count() > 0) return true;
    }

    public function create(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'surat_add')->count() > 0) return true;
    }

    public function edit(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'surat_edit')->count() > 0) return true;
    }

    public function delete(User $user)
    {
        if($user->is_superadmin == 1 || $user->permission()->where('permission', 'surat_delete')->count() > 0) return true;
    }
}
