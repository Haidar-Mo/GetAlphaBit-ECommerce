<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\HomePageResource;
use App\Services\HomePageService;
use App\Traits\FormattedResponse;
use Exception;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    use FormattedResponse;
    protected $homePageService;

    public function __construct(HomePageService $homePageService)
    {
        $this->homePageService = $homePageService;
    }

    public function index()
    {
        try {
            $homePage = $this->homePageService->index();
            return $this->success(
                new HomePageResource($homePage),
                'Home Page Retrieved successfully'
            );
        } catch (Exception $e) {
            return $this->error($e);
        }
    }
}
