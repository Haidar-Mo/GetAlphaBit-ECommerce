<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
/**
 * Class AuthService.
 */
class AuthService
{
    public function register($data)
    {
        $user = User::create([
            'first_name' => $data->first_name,
            'last_name' => $data->last_name,
            'email' => $data->email,
            'phone_number' => $data->phone_number,
            'address' => $data->address,
            'password' => $data->password,
        ]);


        return $user;
    }


    public function login(Request $request)
    {
        return $request->has('email')
            ? $this->loginWithEmail($request)
            : $this->loginWithPhone($request);
    }

    public function loginWithEmail($data)
    {
        $query = User::query();
        if (!empty($data->email)) {
            $user = $query->where('email', $data->email)->first();
            if (!$user || !Hash::check($data->password, $user->password)) {
                return null;
            }
            if (Auth()->user()) {
                Auth()->user()->tokens()->delete();
            }
            $access_token = $user->createToken('access_token')->plainTextToken;
            $refresh_token = $user->createToken('refresh_token')->plainTextToken;

            $user->access_token = $access_token;
            $user->refresh_token = $refresh_token;

            return $user;
        }

    }
    public function loginWithPhone($data)
    {
        $query = User::query();
        if (!empty($data->phone_number)) {
            $user = $query->where('phone_number', $data->phone_number)->first();
            if (!$user || !Hash::check($data->password, $user->password)) {
                return null;
            }
            if (Auth()->user()) {
                Auth()->user()->tokens()->delete();
            }
            $access_token = $user->createToken('access_token')->plainTextToken;
            $refresh_token = $user->createToken('refresh_token')->plainTextToken;

            $user->access_token = $access_token;
            $user->refresh_token = $refresh_token;

            return $user;
        }

    }

    public function logout($user)
    {
        $user->tokens()->delete();
        return true;
    }

    public function refresh($user)
    {
        $user->tokens()->delete();
        $access_token = $user->createToken('access_token')->plainTextToken;
        $refresh_token = $user->createToken('refresh_token')->plainTextToken;

        $user->access_token = $access_token;
        $user->refresh_token = $refresh_token;

        return $user;
    }
}