<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UsersServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
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
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);
        $user = $this->userServiceInterface->getUserByEmail($credentials['email']);
        if (empty($user) || ! Hash::check($credentials['password'], $user->password)) {
            $error = [
                'email' => [],
                'password' => []
            ];
            if (empty($user)) {
                array_push($error['email'], 'The provided credentials are incorrect.');
            }
            if (! Hash::check($credentials['password'], $user->password)) {
                array_push($error['password'], 'password not correct');
            }
            return response()->json([
                'message' => 'Unauthorized',
                'errors' => $error],
                401);
        }
        $infoToken = $user->createToken($credentials['email'], ['sever:createNewToken']);

        return response()->json([
            'token_access' => $infoToken->plainTextToken,
            'id_token' => $infoToken->accessToken->id,
            'email' => $credentials['email'],
            'userId' => $user->id
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        return response()->json([
            'status' => $this->userServiceInterface->deleteTokenUserByIdToken($request->get('emailLogin'), $request->get('idToken'))
        ]);
    }
}
