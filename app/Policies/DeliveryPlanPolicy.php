<?php

namespace App\Policies;

use App\Models\DeliveryPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryPlanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool {}

    public function view(User $user, DeliveryPlan $deliveryPlan): bool {}

    public function create(User $user): bool {}

    public function update(User $user, DeliveryPlan $deliveryPlan): bool {}

    public function delete(User $user, DeliveryPlan $deliveryPlan): bool {}

    public function restore(User $user, DeliveryPlan $deliveryPlan): bool {}

    public function forceDelete(User $user, DeliveryPlan $deliveryPlan): bool {}
}
