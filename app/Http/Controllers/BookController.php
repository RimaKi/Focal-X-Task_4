<?php

namespace App\Http\Controllers;

use App\Http\Requests\Book\AddRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Models\Book;
use App\Services\BookServices;
use Illuminate\Http\Request;


class BookController extends Controller
{
    /**
     * @var BookServices
     */
    protected $bookServices;

    /**
     *  use Service in controller
     *  in this controller use dependency injection
     * @param BookServices $bookServices
     */
    public function __construct(BookServices $bookServices)
    {
        $this->bookServices = $bookServices;
    }


    /**
     *   Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */

    public function index(Request $request)
    {
        return $this->bookServices->indexBooks($request);
    }


    /**
     *  Store a newly created resource in storage.
     * @param AddRequest $request
     * @return string
     * @throws \Exception
     */
    public function store(AddRequest $request)
    {
        $data = $request->only('title', 'author_id', 'description', 'published_at');
        $book = $this->bookServices->StoreBook($data);
        return 'The book has been added successfully';
    }


    /**
     *   Display the specified resource.
     * @param Book $book
     * @return Book
     */
    public function show(Book $book)
    {
        return $this->bookServices->ShowBook($book);
    }


    /**
     *   Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Book $book
     * @return array
     */
    public function update(UpdateRequest $request, Book $book)
    {
        $data = $request->only(['title', 'author_id', 'description', 'published_at']);
        $book = $this->bookServices->updateBook($data, $book);
        return ['book' => $book, "message" => 'updated successfully'];
    }


    /**
     *  Remove the specified resource from storage.
     * @param Book $book
     * @return string
     * @throws \Exception
     */
    public function destroy(Book $book)
    {
        $this->bookServices->deleteBook($book);
        return "deleted successfully";
    }
}
