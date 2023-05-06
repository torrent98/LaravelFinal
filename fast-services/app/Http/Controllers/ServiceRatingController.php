<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Rating;
use App\Http\Resources\RatingCollection;

class ServiceRatingController extends Controller
{
    public function index($service_id)
    {
        $rating = Rating::get()->where('service', $service_id);
        if (count($rating) == 0)
            return response()->json('Data not found', 404);
        return new RatingCollection($apprat);
    }
}
