<?php

namespace App\Services;

use App\Models\Borrow_record;

class BorrowService
{
    /**
     * update borrow record with user permission verification
     * @param $data
     * @param Borrow_record $borrow_record
     * @return Borrow_record
     * @throws \Exception
     */
    public function updateBorrow($data, Borrow_record $borrow_record)
    {
        $correct_data = [
            'book_id' => $data['book_id'] ?? $borrow_record->book_id,
            'borrowed_at' => $data['borrowed_at'] ?? $borrow_record->borrowed_at,
            'returned_at' => $data['returned_at'] ?? $borrow_record->returned_at
        ];

        (new BookServices())->availableBook($correct_data);
        if ($borrow_record->user_id != auth()->user()->id) {
            throw new \Exception('You do not have permission to edit this borrow record.');
        }
        $borrow_record->update($correct_data);
        return $borrow_record;
    }

    /**
     *  delete borrow record with user permission verification
     * @param Borrow_record $borrow_record
     * @return void
     * @throws \Exception
     */
    public function deleteBorrow(Borrow_record $borrow_record)
    {
        if ($borrow_record->user_id != auth()->user()->id) {
            throw new \Exception('You do not have permission to delete this borrow record.');
        }
        if (!$borrow_record->delete()) {
            throw new \Exception('Error deleting the borrow record');
        }
    }

}
