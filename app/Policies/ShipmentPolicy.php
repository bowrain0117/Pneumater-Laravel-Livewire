<?php

namespace App\Policies;

use App\Enums\ShipmentStatus;
use App\Enums\User\CustomerType;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShipmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Shipment $shipment)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->isA('customer')) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can print the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function print(User $user)
    {
        if ($user->isA('customer') && $user->customer_type != CustomerType::Dropshipping) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Shipment $shipment)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Shipment $shipment)
    {
        if ($user->isA('customer') && $shipment->status != ShipmentStatus::ToBeConfirmed && $shipment->status != ShipmentStatus::Confirmed) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Shipment $shipment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Shipment $shipment)
    {
        //
    }
}
