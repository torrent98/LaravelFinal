<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Http\Resources\RatingCollection;

class MechanicRatingController extends Controller
{
    public function index($mechanic_id)
    {
        $rating = Rating::get()->where('mechanic', $mechanic_id);
        if (count($rating) == 0)
            return response()->json('Data not found', 404);
        return new RatingCollection($rating);
    }
}
