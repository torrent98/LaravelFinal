<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Http\Resources\RatingCollection;


class UserRatingController extends Controller
{
    public function index($user_id)
    {
        $rating = Rating::get()->where('user', $user_id);
        if (count($rating) == 0)
            return response()->json('Data not found', 404);
        return new RatingCollection($rating);
    }

    public function myrating()
    {
        if(auth()->user()->isAdmin())
            return response()->json('You are not allowed to have ratings.');  
        $rating = Rating::get()->where('user', auth()->user()->id);
        if (count($rating) == 0)
            return response()->json('Data not found', 404);
        return new RatingCollection($rating);

    }
}
