<?php

namespace App\Services;

use App\Models\Rate;

class RateService
{

    /**
     *  update rate with user permission verification
     * @param $data
     * @param Rate $rate
     * @return Rate
     * @throws \Exception
     */
    public function updateRate($data, Rate $rate)
    {
        if ($rate->user_id != auth()->user()->id) {
            throw new \Exception('You do not have permission to edit this rate');
        }
        $rate->update([
            'rating' => 3.7,
            'review' => $data['review'] ?? $rate->review
        ]);
        return $rate;
    }

    /**
     *   update rate with user permission verification
     * @param Rate $rate
     * @return void
     * @throws \Exception
     */
    public function deleteRate(Rate $rate)
    {
        if ($rate->user_id != auth()->user()->id) {
            throw new \Exception('You do not have permission to delete this rate');
        }
        if (!$rate->delete()) {
            throw new \Exception('Error deleting the borrow record');
        }
    }
}
