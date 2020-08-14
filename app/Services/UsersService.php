<?php

namespace App\Services;
use App\Model\Profile;
use App\Model\Role;
use App\Services\Contracts\UsersServiceInterface;
use App\Model\User;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersService implements UsersServiceInterface
{
    private $role;
    private $user;
    private $profile;
    public function __construct(Role $role, User $user, Profile $profile)
    {
        $this->role = $role;
        $this->user = $user;
        $this->profile = $profile;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array_reverse($this->role->getRoles());
    }

    /**
     * @return array
     */
    public function getListUser(){
        return array_reverse($this->user->getUsers());
    }

    /**
     * @param int $id
     * @return array
     */
    public function getProfileById(int $id){
        return array_reverse($this->user->getProfileByUserId($id));
    }

    /**
     * @param $email
     * @return Builder|object|null
     */
    public function getUserByEmail($email){
        return $this->user->getUserByEmail($email);
    }

    /**
     * @param $request
     * @param $id
     * @return bool|string
     */
    public function updateProfileUser($request, $id)
    {
        DB::beginTransaction();
        try {
            $this->user->updateUserById($request, $id);
            $this->profile->updateProfileByUserId($request->get('role_id'), $id);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    /**
     * @param Request $request
     * @param int $id
     * @return string
     */
    public function verifyOldPassword($request, int $id){
        $user = $this->user->getUserById($id);
        $ruleVerify = '';
        if (!Hash::check($request->get('password_old'), $user->password)) {
            $ruleVerify = 'confirmed';
        }

        return $ruleVerify;
    }

    /**
     * @param $request
     * @return bool|string
     */
    public function createUserProfile($request){
        DB::beginTransaction();
        try {
            $user = $this->user->createUser($request);
            $this->profile->createProfileUser($user->id, $request->get('role'));
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $request
     * @param $id
     * @return bool|string
     */
    public function updateUser($request, $id){
        DB::beginTransaction();
        try {
            $this->user->updateUserById($request, $id);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteUserProfileByUserId($id){
        DB::beginTransaction();
        try {
            $this->user->deleteUserById($id);
            $this->profile->deleteProfileByUserId($id);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param $emailLogin
     * @param $idToken
     * @return bool
     */
    public function deleteTokenUserByIdToken($emailLogin, $idToken){
        $user = $this->getUserByEmail($emailLogin);
        DB::beginTransaction();
        try {
            $user->tokens()->where('id', $idToken)->delete();
            DB::commit();
            Auth::logout();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function make(array $request)
    {
        // TODO: Implement make() method.
        // put all the logic in this class
    }
}