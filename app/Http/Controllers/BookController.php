<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\BookCollection;
use App\Book;
use Illuminate\Support\Facades\Hash;

class BookController extends Controller
{
    // all books
    public function index()
    {
        $books = Book::all()->toArray();
        return array_reverse($books);
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

        $book = new Book([
            'name' => $request->input('name'),
            'author' => $request->input('author')
        ]);
        $book->save();

        return response()->json('The book successfully added');
    }

    /**
     * @param         $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $book = Book::find($id);
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
        $book = Book::find($id);
        $book->update($request->all());

        return response()->json('The book successfully updated');
    }

    // delete book
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();

        return response()->json('The book successfully deleted');
    }
}
