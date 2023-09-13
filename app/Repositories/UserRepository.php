<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserRepository {

    public function store(array $att) : Model | User {
        return User::query()->create($att);
    }

}
