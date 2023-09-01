<?php

namespace App\Services;

use App\Models\Link;
use App\Models\User;
use App\Repositories\LinkRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;

class LinkService
{
    protected LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function generatePath(User $user): string
    {
        $link = $this->generateLink($user);
        return route('main.page', ['token' => $link->token]);
    }

    public function deactivateLinkForCurrentUser(string $token): void
    {
        $this->linkRepository->findByToken($token)->delete();
    }

    protected function generateLink(Authenticatable|null $user): Link
    {
        return $this->linkRepository->create([
            'user_id' => $user->id,
            'token' => uniqid(),
            'expires_at' => Carbon::now()->addDays(7),
        ]);
    }

    public function regeneratePathForUser(string $token): string
    {
        $token = $this->linkRepository->findByToken($token);

        $token->update(['token' => uniqid(), 'expires_at' => Carbon::now()->addDays(7)]);

        return route('main.page', ['token' => $token->token]);
    }
}

