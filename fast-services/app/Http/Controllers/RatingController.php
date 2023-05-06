<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

use App\Models\Mechanic;
use App\Models\Service;

use App\Http\Resources\RatingResource;
use App\Http\Resources\RatingCollection;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new RatingCollection(Rating::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_and_time' => 'required|date',
            'service' => 'required|numeric|gte:1|lte:5',
            'rating' => 'required|numeric|lte:5|gte:1',
            'note' => 'required|string|min:20',
            'mechanic' => 'required|numeric|gte:1|lte:10',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        if(auth()->user()->isAdmin())
            return response()->json('You are not authorized to create new ratings.'); 

        $rating = Rating::create([
            'date_and_time' => $request->date_and_time,
            'user' => auth()->user()->id,
            'service' => $request->service,
            'rating' => $request->rating,
            'note' => $request->note,
            'mechanic' => $request->mechanic,
        ]);

        return response()->json(['Rating is created successfully.', new RatingResource($rating)]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Rating $rating)
    {
        return new RatingResource($rating);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $ratings)
    {
        $validator = Validator::make($request->all(), [
            'date_and_time' => 'required|date',
            'user' => 'required|numeric|digits_between:1,5',
            'service' => 'required|numeric|gte:1|lte:5',
            'rating' => 'required|numeric|lte:5|gte:1',
            'note' => 'required|string|min:20',
            'mechanic' => 'required|numeric|gte:1|lte:10',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        if(auth()->user()->isAdmin())
            return response()->json('You are not authorized to update ratings.');    

        if(auth()->user()->id != $apprat->user)
            return response()->json('You are not authorized to update someone elses ratings.');     

        $ratings->date_and_time = $request->date_and_time;
        $ratings->user = auth()->user()->id;
        $ratings->service = $request->service;
        $ratings->rating = $request->rating;
        $ratings->note = $request->note;
        $ratings->mechanic = $request->mechanic;

        $ratings->save();

        return response()->json(['Appointment rating is updated successfully.', new RatingResource($ratings)]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        if(auth()->user()->isAdmin())
            return response()->json('You are not authorized to delete ratings.');    

        if(auth()->user()->id != $rating->user)
            return response()->json('You are not authorized to delete someone elses ratings.');

        $rating->delete();

        return response()->json('Rating is deleted successfully.');

    }
}
