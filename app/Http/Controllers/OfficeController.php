<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Resources\OfficeResource;
use App\Models\Office;
use Exception;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function GetAllOffices()
    {
        $offices = Office::with(
            ['projectProposals', 'users']
        )->get();
        return OfficeResource::collection($offices);
    }

    public function AddOffice(StoreOfficeRequest $request)
    {
        $validateData = $request->validated();
        $office = Office::create($validateData);
        return response()->json([
            'message' => 'Office added successfully',
            'office' => new OfficeResource($office)
        ], 201);
    }

    public function GetOffice($id)
    {
        try {
            $office = Office::with('projectProposals')->findOrFail($id);
            return response()->json([
                'message' => 'Office found successfully',
                'office' => new OfficeResource($office)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Office not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function UpdateOffice($id, StoreOfficeRequest $request)
    {
        try {
            $office = Office::with('projectProposals')->findOrFail($id);
            $validateData = $request->validated();
            $office->update($validateData);
            return response()->json([
                'message' => 'Office updated successfully',
                'office' => new OfficeResource($office)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Office not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function DeleteOffice($id)
    {
        try {
            $office = Office::with('projectProposals')->findOrFail($id);
            $office->delete();
            return response()->json([
                'message' => 'Office deleted successfully',
                'office' => new OfficeResource($office)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Office not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
