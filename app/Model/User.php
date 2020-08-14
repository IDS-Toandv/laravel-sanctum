<?php

namespace App\Model;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return array
     */
    public function getUsers(){
        $data = DB::table($this->table)
                ->select( 'users.*', 'profilesRole.roleName')
                ->join(DB::raw('(select pr.user_id as user_id, rl.name as roleName from profiles 
                        as pr inner join roles as rl on pr.role_id = rl.id) as profilesRole'), function($join){
                    $join->on( 'users.id', '=', 'profilesRole.user_id');
                })
                ->where('flg_deleted', false)
                ->get();

        return $data->toArray();
    }

    /**
     * @param $userId
     * @return array
     */
    public function getProfileByUserId($userId){
        $data = DB::table($this->table)
                ->select('users.name', 'users.email', 'pr.role_id')
                ->join('profiles as pr', 'users.id', '=', 'pr.user_id')
                ->where([
                    ['users.id', $userId],
                    ['flg_deleted', false]
                ])
                ->get();

        return $data->toArray();
    }

    /**
     * @param $email
     * @return Builder|object|null
     */
    public function getUserByEmail($email) {
        return User::where([
            ['email', $email],
            ['flg_deleted', false]
        ])->first();
    }

    /**
     * @param $id
     * @return Builder|object|null
     */
    public function getUserById($id){
        return DB::table($this->table)->where([
            ['id', $id],
            ['flg_deleted', false]
        ])->first();
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function updateUserById($request, $id) {
        return DB::table($this->table)
            ->where('id', $id)
             ->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password_new')),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function createUser($request){
        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    /**
     * @param $id
     */
    public function deleteUserById($id){
        DB::table($this->table)
          ->where('id', $id)
          ->update([
              'flg_deleted' => 1,
          ]);
    }
}
