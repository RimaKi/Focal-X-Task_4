<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rate\StoreRequest;
use App\Http\Requests\Rate\UpdateRequest;
use App\Models\Rate;
use App\Services\RateService;
use Illuminate\Http\Request;

class RateController extends Controller
{

    /**
     *  Display a listing of the resource.
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        return Rate::when($request->book_id, function ($q) use ($request) {
            return $q->where('book_id', $request->book_id);
        })->get();
    }


    /**
     *  Store a newly created resource in storage.
     * @param StoreRequest $request
     * @return string
     */
    public function store(StoreRequest $request)
    {
        $data = $request->only('book_id', 'user_id', 'rating', 'review');
        Rate::create($data);
        return "added successfully";
    }


    /**
     *  Display the specified resource.
     * @param Rate $rate
     * @return Rate
     */
    public function show(Rate $rate)
    {
        return $rate->load('user', 'book');
    }


    /**
     *  Update the specified resource in storage.
     * @param UpdateRequest $request
     * @param Rate $rate
     * @return Rate
     * @throws \Exception
     */
    public function update(UpdateRequest $request, Rate $rate)
    {
        $data = $request->only('rating', 'review');
        return (new RateService())->updateRate($data, $rate);
    }


    /**
     *  Remove the specified resource from storage.
     * @param Rate $rate
     * @return string
     * @throws \Exception
     */
    public function destroy(Rate $rate)
    {
        (new RateService())->deleteRate($rate);
        return "deleted successfully";
    }
}
