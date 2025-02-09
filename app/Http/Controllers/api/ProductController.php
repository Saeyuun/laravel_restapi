<?php

namespace App\Http\Controllers\api;

use App\Models\Shoes;
use App\Http\Resources\ShoesResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shoes = Shoes::get(); //gets all the shoes and instantiate inside $shoes variable
        if($shoes->count() > 0) { //counts the number of shoes
            return ShoesResource::collection($shoes); //returns the shoes
        } 
        else {
            return response()->json([
                'message' => 'No products found'
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'size' => 'required|numeric',
            'color' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);

        $shoes = shoes::create($request->all(
            'name',
            'quantity',
            'size',
            'color',
            'price',
            'description'
        ));

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        } 
        else {
            return response()->json([
                'message' => 'Product created successfully',
                'data' => new ShoesResource($shoes)
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Shoes $shoe)
    {
        return new ShoesResource($shoe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shoes $shoes)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'size' => 'required|numeric',
            'color' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);

        $shoes->update(attributes: [
            'name' => $request->name,
            'quantity' => $request->quantity,
            'size' => $request->size,
            'color' => $request->color,
            'price' => $request->price,
            'description' => $request->description
        ]
        );

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        } 
        else {
            return response()->json([
                'message' => 'Product updated successfully',
                'data' => new ShoesResource($shoes)
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shoes $shoe)
    {
        $shoe->delete();
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
