<?php

namespace App\Http\Controllers;

use App\Repositories\GameResultRepository;
use App\Repositories\LinkRepository;
use App\Services\LinkService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MainController extends Controller
{
    protected LinkService $linkService;
    protected LinkRepository $linkRepository;
    protected GameResultRepository $gameResultRepository;

    public function __construct(LinkService $linkService, LinkRepository $linkRepository, GameResultRepository $gameResultRepository)
    {
        $this->linkService = $linkService;
        $this->linkRepository = $linkRepository;
        $this->gameResultRepository = $gameResultRepository;
    }

    public function show($token): View
    {
        $link = $this->linkRepository->findByToken($token);

        return view('main', ['link' => $link->token]);
    }

    public function playRandom(Request $request): RedirectResponse
    {
        $randomNumber = rand(1, 1000);
        $winResult = ($randomNumber % 2 === 0) && $randomNumber !== 0 ? 'Win' : 'Lose';

        if ($winResult === 'Win') {
            if ($randomNumber > 900) {
                $winAmount = $randomNumber * 0.7;
            } elseif ($randomNumber > 600) {
                $winAmount = $randomNumber * 0.5;
            } elseif ($randomNumber > 300) {
                $winAmount = $randomNumber * 0.3;
            } else {
                $winAmount = $randomNumber * 0.1;
            }
        }

        $this->gameResultRepository->storeResult($this->linkRepository->findByToken($request->token)->user_id, $winResult, $winAmount ?? 0);

        return redirect()->route('main.page', ["token" => $request->token])->with('randomResult', [
            'number' => $randomNumber,
            'result' => $winResult,
            'winAmount' => $winAmount ?? 0,
        ]);
    }

    public function history(Request $request): View
    {
        $history = $this->gameResultRepository->getUserResults($this->linkRepository->findByToken($request->token)->user_id);
        return view('main', ['history' => $history, 'link' => $request->token]);
    }
}
