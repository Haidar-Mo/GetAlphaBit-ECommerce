<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
/**
 * Class AuthService.
 */
class AuthService
{
    public function register($data){
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'phone_number' => $data->phone_number,
            'address' => $data->address,
            'password' => Hash::make($data->password),
        ]);
        

        return $user;
    }

    public function login($data){
        $user = User::where('email',$data->email ?? null)->orWhere('phone_number',$data->phone_number ?? null)->first();

        if(!$user || !Hash::check($data->password,$user->password)){
            return null;
        }

        $access_token = $user->createToken('access_token')->plainTextToken;
        $refresh_token = $user->createToken('refresh_token')->plainTextToken;

        $user->access_token = $access_token;
        $user->refresh_token = $refresh_token;

        return $user;
    }

    public function logout($user){
        $user->tokens()->delete();
        return true;
    }

    public function refresh($user){
        $user->tokens()->delete();
        $access_token = $user->createToken('access_token')->plainTextToken;
        $refresh_token = $user->createToken('refresh_token')->plainTextToken;

        $user->access_token = $access_token;
        $user->refresh_token = $refresh_token;

        return $user;
    }
}