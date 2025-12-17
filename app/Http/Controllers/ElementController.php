<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreElementRequest;
use App\Http\Requests\UpdateElementRequest;
use App\Http\Resources\ElementResource;
use App\Http\Service\ElementService;
use App\Models\Element;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ElementController extends Controller
{
    private ElementService $elementService;
    public function __construct(ElementService $elementService)
    {
        $this->elementService = $elementService;
    }
    public function GetAllelemnts()
    {
        $elements = $this->elementService->getAllElements();
        return ElementResource::collection($elements);
    }

    public function AddElement(StoreElementRequest $request)
    {
        $validated = $request->validated();
        $element = $this->elementService->addElement($validated);
        return response()->json([
            'message' => 'Element created successfully',
            'data' => $element
        ], 201);
    }

    public function UpdateElement(UpdateElementRequest $request, $id)
    {
            $validated = $request->validated();
            $element = $this->elementService->updateElement($validated, $id);
            return response()->json([
                'message' => 'Element updated successfully',
                'data' => $element
            ], 200);
    }


    public function GetEelemnt($id)
    {
        $element = $this->elementService->getElementById($id);
        return response()->json([
            'message' => $element['message'],
            'element' => $element['success']
                ? new ElementResource($element['element'])
                : null
        ], $element['status']);
    }


    public function DeleteElement($id)
    {
        try {
            $element = Element::findOrFail($id);
            $element->delete();
            return response()->json([
                'message' => 'Element deleted successfully',
                'data' => $element
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Element not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
