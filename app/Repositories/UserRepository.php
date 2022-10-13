<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function save(User $user): User
    {
        $user->setPassword(Hash::make($user->getPassword()));
        $user->save();

        return $user;
    }

    public function getById(int $userId): ?User
    {
        return User::find($userId);
    }
}
