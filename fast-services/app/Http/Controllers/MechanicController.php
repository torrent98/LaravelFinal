<?php

namespace App\Http\Controllers;

use App\Models\Mechanic;
use Illuminate\Http\Request;

use App\Models\Rating;
use App\Models\Service;

use App\Http\Resources\MechanicResource;
use App\Http\Resources\MechanicCollection;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class MechanicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mechanics = Mechanic::all();
        return new MechanicCollection($mechanics);
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
            'name' => 'required|string|max:150',
            'phone_number' => 'required|string|max:150|unique:mechanics',
            'years_of_experience' => 'required|numeric|lte:30|gte:1',
            'email' => 'required|email|unique:mechanics',
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        if(auth()->user()->isUser())
            return response()->json('You are not authorized to create new providers.'); 


        $mechanics = Mechanic::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'years_of_experience' => $request->years_of_experience,
            'email' => $request->email,
        ]);
    
        return response()->json(['Mechanic is created successfully.', new MechanicResource($mechanics)]);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Mechanic $mechanic)
    {
        return new MechanicResource($mechanic);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mechanic $mechanic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mechanic $mechanics, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150',
            'phone_number' => 'required|string|max:150|unique:mechanics,phone_number,'.$mechanics->id,
            'years_of_experience' => 'required|numeric|lte:30|gte:1',
            'email' => 'required|email|unique:mechanics,email,'.$mechanics->id,
        ]);

        if ($validator->fails())
            return response()->json($validator->errors());

        if(auth()->user()->isUser())
            return response()->json('You are not authorized to update mechanics.');      

        $mechanics->name = $request->name;
        $mechanics->phone_number = $request->phone_number;
        $mechanics->years_of_experience = $request->years_of_experience;
        $mechanics->email = $request->email;

        $mechanics->save();

        return response()->json(['Mechanic is updated successfully.', new MechanicResource($mechanics)]);

    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mechanic $mechanic)
    {
        if(auth()->user()->isUser())
            return response()->json('You are not authorized to delete mechanics.');
            
        $rating = Rating::get()->where('mechanic', $mechanic->id);
        if (count($rating) > 0)
            return response()->json('You cannot delete mechanics that have ratings.');

        $mechanic->delete();

        return response()->json('Mechanic is deleted successfully.');

    }
}
