<?php

namespace App\Http\Controllers\API;

use App\DTOs\OAuthDataDTO;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['module'] = Config::get('module');

        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthenticated.'], 401);

        $tokenService = new TokenService($request->email, $request->password);

        return (new OAuthDataDTO($tokenService->tokenType(), $tokenService->expiresIn(), $tokenService->accessToken(), $tokenService->refreshToken()))
            ->jsonSerialize();
    }

    function registration(RegistrationRequest $request)
    {
        User::create([
            'module' => Config::get('module'),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $tokenService = new TokenService($request->email, $request->password);

        return (new OAuthDataDTO($tokenService->tokenType(), $tokenService->expiresIn(), $tokenService->accessToken(), $tokenService->refreshToken()))
            ->jsonSerialize();
    }

    function me(Request $request)
    {
        if ($request->isMethod('get'))
            return $request->user();

        $data = $request->validate([
            'name' => 'string|min:3',
            'email' => 'email'
        ]);

        $user = $request->user();
        $user->update($data);

        return $user;
    }

    function logout(Request $request)
    {
        $request->user()
            ->token()
            ->revoke();

        return response()->json(null, 204);
    }
}
