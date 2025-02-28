<?php

namespace App\Policies;

use App\Common\Enums\Permission;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostApprovalPolicy
{
    use HandlesAuthorization;
    public function approve(User $admin)
    {
        return $admin->can(Permission::CAN_APPROVE_POST)
        ? Response::allow()
        : Response::deny('You do not have permission to approve posts.');
    }

    public function reject(User $admin)
    {
        return $admin->can(Permission::CAN_REJECT_POST)
        ? Response::allow()
        : Response::deny('You do not have permission to reject posts.');
    }
}
