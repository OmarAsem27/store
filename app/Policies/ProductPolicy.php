<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy extends ModelPolicy
{
    // extends the base model policy class instead of making a new policy for each model


    // public function before($user, $ability)
    // {
    //     if ($user->super_admin) {
    //         return true;
    //     }
    // }


    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny($user): bool
    // {
    //     return $user->hasAbility('products.view');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    // public function view($user, Product $product): bool
    // {
    //     return $user->hasAbility('products.view') && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can create models.
    //  */
    // public function create($user): bool
    // {
    //     return $user->hasAbility('products.create');
    // }

    // /**
    //  * Determine whether the user can update the model.
    //  */
    // public function update($user, Product $product): bool
    // {
    //     return $user->hasAbility('products.update') && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can delete the model.
    //  */
    // public function delete($user, Product $product): bool
    // {
    //     return $user->hasAbility('products.delete') && $product->store_id == $user->store_id;
    // }

    // /**
    //  * Determine whether the user can restore the model.
    //  */
    // public function restore($user, Product $product): bool
    // {
    //     //
    // }

    // /**
    //  * Determine whether the user can permanently delete the model.
    //  */
    // public function forceDelete($user, Product $product): bool
    // {
    //     //
    // }
}
