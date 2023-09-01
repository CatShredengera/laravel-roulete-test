<?php

namespace App\Repositories;

use App\Models\GameResult;
use Illuminate\Database\Eloquent\Collection;

class GameResultRepository
{
    public function storeResult($userId, $result, $amount): void
    {
        GameResult::create([
            'user_id' => $userId,
            'result' => $result,
            'amount' => $amount,
        ]);
    }

    public function getUserResults(int $userId): Collection
    {
        return GameResult::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();
    }
}
