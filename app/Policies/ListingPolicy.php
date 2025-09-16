<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
	public function before(User $user): bool|null
	{
		if ($user->isAdmin()) {
			return true;
		}
		return null;
	}

    public function view(?User $user, Listing $listing): bool
    {
        return $listing->user->role !== 'suspended' && $listing->approved;
    }

    public function create(User $user): bool
    {
        return $user->role !== 'suspended';
    }

    public function modify(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id && $user->role !== 'suspended';
    }

	public function approve(User $user, Listing $listing): bool
	{
		return $user->isAdmin();
	}
}
