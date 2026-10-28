<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ListUsers
{
    /**
     * @return Collection<int, User>
     */
    public function handle(): Collection
    {
        return User::query()
            ->latest('id')
            ->get();
    }
}
