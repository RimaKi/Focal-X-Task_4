<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRecords\StoreRequest;
use App\Http\Requests\BorrowRecords\UpdateRequest;
use App\Models\Borrow_record;
use App\Services\BorrowService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BorrowRecordController extends Controller
{

    /**
     *  Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function index(Request $request)
    {
        $borrows = Borrow_record::query()->paginate($request->borrows_number);
        return $borrows;
    }


    /**
     *  Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return string
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only(['book_id', 'borrowed_at', 'user_id', 'returned_at']);
        Borrow_record::create($data);
        return "The book's borrowing date has been added.";
    }


    /**
     *  Display the specified resource.
     * @param Borrow_record $borrow_record
     * @return Borrow_record
     */
    public function show(Borrow_record $borrow_record)
    {
        return $borrow_record->load('book', 'user');
    }


    /**
     *  Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Borrow_record $borrow_record
     * @return Borrow_record
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Borrow_record $borrow_record)
    {
        $data = $request->only('book_id', 'borrowed_at');
        return (new BorrowService())->updateBorrow($data, $borrow_record);
    }


    /**
     *  Remove the specified resource from storage.
     * @param Borrow_record $borrow_record
     * @return string
     * @throws \Exception
     */
    public function destroy(Borrow_record $borrow_record)
    {
        (new BorrowService())->deleteBorrow($borrow_record);
        return 'deleted successfully';
    }

    /**
     * Add due date for return book
     * @param Borrow_record $borrow_record
     * @return string
     */
    public function restore(Borrow_record $borrow_record)
    {
        $borrow_record->update([
            'due_date' => Carbon::now()
        ]);
        return "added due date successfully";
    }
}
