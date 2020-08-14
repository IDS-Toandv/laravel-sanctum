<?php

namespace App\Services\Contracts;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use KesmenEnver\ServiceLayer\ServiceInterface;


interface UsersServiceInterface extends ServiceInterface
{
    /**
     * @return array
     */
    public function getRoles();

    /**
     * @return array
     */
    public function getListUser();

    /**
     * @param int $id
     * @return array
     */
    public function getProfileById(int $id);

    /**
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function verifyOldPassword($request, int $id);

    /**
     * @param $email
     * @return Builder|object|null
     */
    public function getUserByEmail($email);

    /**
     * @param $request
     * @param $id
     * @return bool|string
     */
    public function updateProfileUser($request, $id);

    /**
     * @param $request
     * @return bool|string
     */
    public function createUserProfile($request);

    /**
     * @param $request
     * @param $id
     * @return bool|string
     */
    public function updateUser($request, $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteUserProfileByUserId($id);

    /**
     * @param $emailLogin
     * @param $idToken
     * @return bool
     */
    public function deleteTokenUserByIdToken($emailLogin, $idToken);
}