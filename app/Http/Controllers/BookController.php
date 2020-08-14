<?php

namespace App\Http\Controllers;

use App\Services\Contracts\BooksServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class BookController extends Controller
{
    private $bookServiceInterface;
    public function __construct(BooksServiceInterface $bookServiceInterface)
    {
        $this->bookServiceInterface = $bookServiceInterface;
    }

    /**
     * @return Collection
     */
    public function index()
    {
        return $this->bookServiceInterface->getListBooks();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function add(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'author' => ['required'],
        ]);

        $statusCreate = $this->bookServiceInterface->createBook($request);

        return response()->json(['status' => $statusCreate]);
    }

    /**
     * @param         $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $book = $this->bookServiceInterface->getBookById($id);
        return response()->json($book);
    }

    /**
     * @param         $id
     * @param Request $request
     * @return JsonResponse
     */
    public function update($id, Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'author' => ['required'],
        ]);
        $statusUpdate = $this->bookServiceInterface->updateBook($request, $id);

        return response()->json(['status' => $statusUpdate]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $statusDelete = $this->bookServiceInterface->deleteBook($id);
        return response()->json(['status' => $statusDelete]);
    }
}
