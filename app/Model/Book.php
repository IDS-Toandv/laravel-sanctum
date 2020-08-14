<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Book extends Model
{
    protected $table = 'books';
    protected $fillable = ['name', 'author'];

    /**
     * @return Collection
     */
    public function getAllBooks(){
        return DB::table($this->table)->where('flg_deleted', false)->get();
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getBookById($id){
        return DB::table($this->table)->where([
            ['id', $id],
            ['flg_deleted', false]
        ])->get();
    }

    /**
     * @param $request
     */
    public function createBook($request){
         DB::table($this->table)->insert([
            'name' => $request->input('name'),
            'author' => $request->input('author'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }

    /**
     * @param $request
     * @param $id
     */
    public function updateBook($request, $id){
         DB::table($this->table)
             ->where('id', $id)
             ->update([
                 'name' => $request->input('name'),
                 'author' => $request->input('author'),
                 'updated_at' => Carbon::now()
             ]);
    }

    /**
     * @param $id
     */
    public function deleteBook($id){
        DB::table($this->table)
          ->where('id', $id)
          ->update([
              'flg_deleted' => 1,
          ]);
    }
}