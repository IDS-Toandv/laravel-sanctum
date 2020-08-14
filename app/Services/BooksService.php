<?php

namespace App\Services;
use App\Model\Book;
use App\Services\Contracts\BooksServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BooksService implements BooksServiceInterface
{
    private $book;
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    /**
     * @return Collection
     */
    public function getListBooks(){
        return $this->book->getAllBooks();
    }

    /**
     * @param $id
     * @return Collection
     */
    public function getBookById($id){
        return $this->book->getBookById($id);
    }

    /**
     * @param $request
     * @return bool|string
     */
    public function createBook($request){
        DB::beginTransaction();
        try {
            $this->book->createBook($request);
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
    public function updateBook($request, $id){
        DB::beginTransaction();
        try {
            $this->book->updateBook($request, $id);
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
    public function deleteBook($id){
        DB::beginTransaction();
        try {
            $this->book->deleteBook($id);
            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * @param array $request
     */
    public function make(array $request)
        {
            // TODO: Implement make() method.
            // put all the logic in this class
        }
}