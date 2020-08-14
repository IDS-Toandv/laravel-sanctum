<?php

namespace App\Http\Controllers;

use App\Services\Contracts\UsersServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    private $userServiceInterface;
    public function __construct(UsersServiceInterface $userServiceInterface)
    {
        $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->userServiceInterface->getRoles();
    }

    /**
     * @return array
     */
    public function getListUser(){
        return $this->userServiceInterface->getListUser();
    }

    /**
     * @param $id
     * @return array
     */
    public function getProfileById($id){
        return $this->userServiceInterface->getProfileById($id);
    }

    /**
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function editProfile(Request $request, $id){
        $rulePasswordOld = ['required', 'min:8'];
       $elementRule = $this->userServiceInterface->verifyOldPassword($request, intval($id));
       if ($elementRule !== '') {
            array_push($rulePasswordOld, $elementRule);
       }
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'password_old' => $rulePasswordOld,
            'password_new' => ['required', 'min:8', 'confirmed'],
            'role_id' => ['required']
        ]);

        return response()->json([
            'statusUpdate' => $this->userServiceInterface->updateProfileUser($request,  intval($id))
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteProfileUser($id) {
        return response()->json([
            'statusUpdate' => $this->userServiceInterface->deleteUserProfileByUserId(intval($id))
        ]);
    }

}
