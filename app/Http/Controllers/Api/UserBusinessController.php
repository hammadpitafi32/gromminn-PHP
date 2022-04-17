<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserBusinessInterface;
use App\Models\UserBusiness;
use App\Traits\CategoryTrait;
use App\Traits\ServiceTrait;

class UserBusinessController extends Controller
{
    use CategoryTrait;
    use ServiceTrait;
    protected $user_business;
    public function __construct(UserBusinessInterface $user_business)
    {
        $this->user_business = $user_business;
    }

    public function createOrUpdate(Request $request)
    {
        return $this->user_business->createOrUpdate();
        
        // return response()->json([
        //     'success' => $response['success'],
        //     'data' => $response['data']
        // ]);
    }

    public function getUserBusiness($id=null)
    {
        return $this->user_business->getUserBusiness($id);

    }

    public function createOrUpdateSchedule(Request $request)
    {
        
        $response = $this->user_business->createOrUpdateSchedule();
        return response()->json([
            'success' => $response['success'],
            'data' => $response['data']
        ]);
    }

    public function createUserBusinessService(Request $request)
    {

        return $this->user_business->createUserBusinessService();
    }

    public function getUserCategories()
    {
        // dd($this->userCategories());
        $categories = $this->userCategories();

        return response()->json([
            'success' => true,
            'data' => $categories
        ], 200);
    }

    public function getUserServices()
    {
        // dd($this->userServices());
        $services = $this->userServices();

        return response()->json([
            'success' => true,
            'data' => $services
        ], 200);
    }
}
