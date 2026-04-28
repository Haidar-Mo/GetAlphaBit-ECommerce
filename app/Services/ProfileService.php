<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileService.
 */
class ProfileService
{
    public function update($data)
    {
        $query = User::query();
        $user = $query->where('id', auth()->id());
        if (isset($data['first_name'])) {
            $user->first_name = $data['first_name'];
        }
        if (isset($data['last_name'])) {
            $user->last_name = $data['last_name'];
        }
        if (isset($data['email'])) {
            $user->email = $data['email'];
        }
        if (isset($data['phone_number'])) {
            $user->phone_number = $data['phone_number'];
        }
        if (isset($data['address'])) {
            $user->address = $data['address'];
        }
        if (isset($data['new_password'])) {
            if (empty($data['password'] || !Hash::check($data['password'], $user->password))) {
                return null;
            }

            $user->password = $data['new_password'];
        }
        $user->save();
        return $user;

    }

    public function index()
    {
        $query = User::query();
        $user = $query->where('id', auth()->id());
        return $user;
    }

}
