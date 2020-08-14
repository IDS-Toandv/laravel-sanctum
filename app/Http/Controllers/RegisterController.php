<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UsersServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private $userServiceInterface;
    public function __construct(UsersServiceInterface $userServiceInterface)
    {
        $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required']
        ]);
        $statusRegister = $this->userServiceInterface->createUserProfile($request);

        return response()->json([
            'status' => $statusRegister
        ]);
    }
}
