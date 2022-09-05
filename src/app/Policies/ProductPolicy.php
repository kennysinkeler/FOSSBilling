<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\admin;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param Admin $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        if ($admin->can('view products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function view(Admin $admin, Product $product): bool
    {
        if ($admin->can('view products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param Admin $admin
     * @return Response|bool
     */
    public function create(Admin $admin): Response|bool
    {
        if ($admin->can('create products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function update(Admin $admin, Product $product): bool
    {
        if ($admin->can('edit products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return bool
     */
    public function delete(Admin $admin, Product $product): bool
    {
        if ($admin->can('delete products')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the admin can restore the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return Response|bool
     */
    public function restore(Admin $admin, Product $product): Response|bool
    {
        //
    }

    /**
     * Determine whether the admin can permanently delete the model.
     *
     * @param Admin $admin
     * @param Product $product
     * @return Response|bool
     */
    public function forceDelete(Admin $admin, Product $product)
    {
        //
    }
}
