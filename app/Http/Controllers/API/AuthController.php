<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;


class AuthController extends Controller
{
    use FormattedResponse;
    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    public function register(RegisterRequest $request)
    {

        try {
            $user = $this->authService->register($request);

            return $this->success(
                new AuthResource($user),
                'New User Registered Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }

    }


    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->login($request);

            if (!$user) {
                return $this->message(
                    'invalid credentials',
                    [],
                    401,
                    false
                );
            }
            return $this->success(
                new AuthResource($user),
                'User Login Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }


    }

    public function logout(Request $request)
    {

        try {
            $this->authService->logout($request->user());
            return $this->message(
                'User Logout Successfully',
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }


    public function refresh(Request $request)
    {
        try {
            $user = $this->authService->refresh($request->user());
            return $this->success(
                new AuthResource($user),
                'Token Refreshed Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }
}