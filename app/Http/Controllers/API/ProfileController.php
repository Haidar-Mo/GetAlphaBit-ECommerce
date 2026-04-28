<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Services\ProfileService;
use Exception;
use App\Traits\FormattedResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    use FormattedResponse;

    private $profileService;

    public function _construct(ProfileService $profileService)
    {
        return $this->profileService = $profileService;
    }
    public function update(ProfileRequest $request)
    {
        try {
            $user = $this->profileService->update($request);
            return $this->success(
                new ProfileResource($user),
                'User Updated Successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

    public function index()
    {
        try {
            $user = $this->profileService->index();
            return $this->success(
                new ProfileResource($user),
                'User Profile'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }

}
