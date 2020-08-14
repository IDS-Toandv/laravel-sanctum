<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Profile extends Model
{
    protected $table = 'profiles';
    protected $fillable = ['user_id', 'role_id'];

    /**
     * @param $roleId
     * @param $id
     * @return mixed
     */
    public function updateProfileByUserId($roleId, $id) {
        return DB::table($this->table)
                 ->where('user_id', $id)
                 ->update([
                    'role_id' => $roleId
                ]);
    }

    /**
     * @param $userId
     * @param $roleId
     */
    public function createProfileUser($userId, $roleId){
        DB::table($this->table)->insert([
            'user_id' => $userId,
            'role_id' => $roleId,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * @param $userId
     */
    public function deleteProfileByUserId($userId){
        DB::table($this->table)
          ->where('user_id', $userId)
          ->update([
              'flg_deleted' => 1,
          ]);
    }
}