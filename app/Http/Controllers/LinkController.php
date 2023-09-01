<?php

namespace App\Http\Controllers;

use App\Services\LinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected LinkService $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function deactivate(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);
        $this->linkService->deactivateLinkForCurrentUser($request->token);

        return redirect()->route('home')->with('message', 'Link deactivated successfully.');
    }

    public function regenerateLink(Request $request): RedirectResponse
    {
        return redirect($this->linkService->regeneratePathForUser($request->token));
    }
}
