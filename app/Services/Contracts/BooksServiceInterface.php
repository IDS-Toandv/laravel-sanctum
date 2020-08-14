<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use KesmenEnver\ServiceLayer\ServiceInterface;


interface BooksServiceInterface extends ServiceInterface
{
    /**
     * @return Collection
     */
    public function getListBooks();

    /**
     * @param $id
     * @return Collection
     */
    public function getBookById($id);

    /**
     * @param $request
     * @return bool|string
     */
    public function createBook($request);

    /**
     * @param $request
     * @param $id
     * @return bool|string
     */
    public function updateBook($request, $id);

    /**
     * @param $id
     * @return bool
     */
    public function deleteBook($id);
}