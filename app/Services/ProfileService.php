<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class ProfileService.
 */
class ProfileService
{
    /*
    : This is good,because it protect you from null values, but we already do it in the request Validation ("sometimes" attribute do the job)
    : so we just need to update the data  directly (after check the password )
    : see update2()...
    */
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

    /*
    : Here we pass the $request to the service then get the validated data Array to use it in update() method
    : (we can`t pass the validation request directly to the update() method because it expect an array not a request object)
    */
    public function update2($request)
    {
        $data = $request->validated();

        //? This is the authenticated user, we can use it directly. More secure, more fast than query a new one 
        $user = auth()->user();

        if (isset($data['password'])) {
            if (!Hash::check($data['password'], $user->password)) {
                //? Throw Exception if the password wrong, and catch it in the controller to return a formatted response
                throw new \Exception('Current password is incorrect', 400);
            }
            $data['password'] = $data['new_password'];
        }

        $user->update($data);
        return $user;
    }

    /*
    : Index() usually function used to list data, you can use it, but better to use show() function
    : And also return the authenticated user directly without query
    : if want query it, no problem it not a big deal <3 :)
    : see show()...  
    */
    public function index()
    {
        $query = User::query();
        $user = $query->where('id', auth()->id());
        return $user;
    }

    public function show()
    {
        return auth()->user();
    }
}
