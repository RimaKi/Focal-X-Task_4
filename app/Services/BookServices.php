<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Borrow_record;
use Illuminate\Http\Request;

class BookServices
{

    /**
     * show all book with ability filter by (available book , author , title , description) and order by published_at
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function indexBooks(Request $request)
    {
        $data = Book::query()
            ->when($request->isAvailable == true, function ($q) {
                $ids = Book::query()->whereHas('borrow_records', function ($q) {
                    return $q->whereNull('due_date');
                })->select('id')->get()->makeHidden('averageRate');
                return $q->whereNotIn('id', $ids);
            })
            ->when($request->search, function ($query) use ($request) {
                return $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })->when($request->author, function ($query) use ($request) {
                return $query->where('author_id', $request->author);
            })
            ->orderBy('published_at', $request->isAsc ? 'asc' : 'desc')
            ->paginate($request->book_number ?? 20);

        return $data;
    }

    /**
     * service for store book
     * @param $data
     * @return mixed
     * @throws \Exception
     */

    public function StoreBook($data)
    {
        $book = Book::create($data);
        if (!$book) {
            throw new \Exception('added failed');
        }
        return $book;
    }

    /**
     * show book with user and rates details
     * @param Book $book
     * @return Book
     */
    public function ShowBook(Book $book)
    {
        return $book->load('author', 'rates');
    }

    /**
     * update book
     * @param $data
     * @param Book $book
     * @return Book
     */
    public function updateBook($data, Book $book)
    {
        $book->update([
            'title' => $data['title'] ?? $book->title,
            'author_id' => $data['author_id'] ?? $book->author_id,
            'description' => $data['description'] ?? $book->description,
            'published_at' => $data['published_at'] ?? $book->published_at,
        ]);
        return $book;
    }

    /**
     * The deletion process is a soft deletion.
     * @param Book $book
     * @return void
     * @throws \Exception
     */
    public function deleteBook(Book $book)
    {
        if (!$book->delete()) {
            throw new \Exception('Error deleting the book');
        }
    }

    /**
     * Check if the book is available for borrowing
     * @param $data
     * @return void
     * @throws \Exception
     */
    public function availableBook($data)
    {
        $record = Borrow_record::query()->where('book_id', $data['book_id'])
            ->where(function ($q) use ($data) {
                return $q->whereDate('borrowed_at', "<=", $data['borrowed_at'])
                    ->whereDate('returned_at', '>=', $data['borrowed_at'])
                    ->whereNull('due_date')->orWhereDate('due_date', ">=", $data['borrowed_at']);
            })->first();
        if ($record != null) {
            throw new \Exception('الكتاب غير متوفر للاستعارة في الوقت المطلوب');
        }
    }
}
