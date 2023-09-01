<?php

namespace App\Http\Middleware;

use App\Repositories\LinkRepository;
use Closure;
use Illuminate\Http\Request;

class ValidateLink
{
    protected LinkRepository $linkRepository;

    public function __construct(LinkRepository $linkRepository)
    {
        $this->linkRepository = $linkRepository;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->route('token');
        $link = $this->linkRepository->findByToken($token);

        if ($link->isExpired()) {
            abort(404);
        }

        return $next($request);
    }
}
