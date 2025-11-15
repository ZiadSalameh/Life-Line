<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElementRequest;
use App\Http\Requests\UpdateElementRequest;
use App\Http\Resources\ElementResource;
use App\Models\Element;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElementController extends Controller
{
    public function GetAllelemnts()
    {
        $elements = Element::all();
        return ElementResource::collection($elements);
    }

    public function AddElement(StoreElementRequest $request)
    {
        $validated = $request->validated();
        $existData = Element::where('element_name', $validated['element_name'])->first();
        if ($existData) {
            return response()->json([
                'message' => 'Element already exists',
                'data' => $existData
            ], 409);
        }
        $element = Element::create($validated);
        return response()->json([
            'message' => 'Element created successfully',
            'data' => $element
        ], 201);
    }

    public function UpdateElement(UpdateElementRequest $request, $id)
    {

        try {
            $element = Element::findOrFail($id);
            $validated = $request->validated();
            $existData = Element::where('element_name', $validated['element_name'])->first();
            if ($existData) {
                return response()->json([
                    'message' => 'Element already exists',
                    'data' => $existData
                ], 409);
            }
            $element->update($validated);
            return response()->json([
                'message' => 'Element updated successfully',
                'data' => $element
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Element not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function GetEelemnt($id)
    {
        try{
            $element = Element::findOrFail($id);
            return response()->json([
                'message' => 'Element found',
                'data' => new ElementResource($element)
            ], 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Element not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }


    public function DeleteElement($id)
    {
        try{
            $element = Element::findOrFail($id);
            $element->delete();
            return response()->json([
                'message' => 'Element deleted successfully',
                'data' => $element
            ], 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Element not found',
                'error' => $e->getMessage()
            ], 404);
        }
       
    }
}
