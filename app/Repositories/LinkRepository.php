<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    public function create(array $data): Link
    {
        return Link::create($data);
    }

    public function findByToken(string $token): Link|null
    {
        return Link::where('token', $token)->first();
    }

}
