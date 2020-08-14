<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    /**
     * @return array
     */
    public function getRoles(){
        return DB::table($this->table)->get()->toArray();
    }

    /**
     * @param $name
     * @return int
     */
    public function getRoleIdByName($name){
        $role = DB::table($this->table)->where('name', $name)->first()->toArray();
        if (count($role) > 0) {
            return intval($role['id']);
        }

        return 0;
    }
}