<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupplierPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function view(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function restore(User $user, Supplier $supplier)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Supplier  $supplier
     * @return mixed
     */
    public function forceDelete(User $user, Supplier $supplier)
    {
        //
    }

    public function importProduct(User $user)
    {
        return $user->role_id == config('role.admin.supplier') || $user->role_id == config('role.admin.management');
    }
}
