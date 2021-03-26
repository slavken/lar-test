<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegistrationRequest;
use App\Models\User;
use App\Services\TokenService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    function login(LoginRequest $request, TokenService $token)
    {
        $credentials = $request->only('email', 'password');
        $credentials['module'] = Config::get('module');

        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthenticated.'], 401);

        $token->getToken($request);
        return $token->toResponse();
    }

    function registration(RegistrationRequest $request, TokenService $token)
    {
        User::create([
            'module' => Config::get('module'),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token->getToken($request);
        return $token->toResponse();
    }

    function me(Request $request)
    {
        if ($request->isMethod('get'))
            return fractal()
                ->item($request->user(), new UserTransformer)
                ->respond();

        $data = $request->validate([
            'name' => 'string|min:3',
            'email' => 'email'
        ]);

        $user = $request->user();
        $user->update($data);

        return response()->json(['message' => 'success']);
    }

    function logout(Request $request)
    {
        $request->user()
            ->token()
            ->revoke();

        return response()->json(null, 204);
    }
}
