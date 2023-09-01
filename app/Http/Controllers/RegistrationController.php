<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\LinkService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    protected AuthService $authService;
    protected LinkService $linkService;

    public function __construct(AuthService $authService, LinkService $linkService)
    {
        $this->authService = $authService;
        $this->linkService = $linkService;
    }

    public function showRegistrationForm()
    {
        return view('registration');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'phonenumber' => 'required|string',
        ]);

        $user = $this->authService->registerUser($data);

        $link = $this->linkService->generatePath($user);

        return view('registration', ['link' => $link]);
    }
}

