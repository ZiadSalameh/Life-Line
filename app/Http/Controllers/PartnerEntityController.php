<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartnerEntityRequest;
use App\Http\Requests\UpdatePartnerEntityRequest;
use App\Http\Resources\PartnerEntityResource;
use App\Models\PartnerEntity;
use Exception;
use Illuminate\Http\Request;

class PartnerEntityController extends Controller
{
    public function GetAllPartnerEntities()
    {
        $partnerEntities = PartnerEntity::with('projectproposal')->get();
        return PartnerEntityResource::collection($partnerEntities);
    }

    public function GetPartnerEntity($id)
    {
        try {
            $partnerEntity = PartnerEntity::with('projectproposal')->findOrFail($id);
            return new PartnerEntityResource($partnerEntity);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Partner entity not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    public function AddPartnerEntity(StorePartnerEntityRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $existingPartnerEntity = PartnerEntity::where('name', $validatedData['name'])->
            where('projectproposal_id', $validatedData['projectproposal_id'])->exists();
            if ($existingPartnerEntity) {
                return response()->json([
                    'message' => 'Partner entity already exists',
                    'error' => 'Partner entity already exists'
                ], 400);
            }
            $partnerEntity = PartnerEntity::create($validatedData);
            return new PartnerEntityResource($partnerEntity);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to add partner entity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function UpdatePartnerEntity($id,  UpdatePartnerEntityRequest  $request)
    {
        try {
            $validatedData = $request->validated();
            $existingPartnerEntity = PartnerEntity::where('name', $validatedData['name'])->
            where('projectproposal_id', $validatedData['projectproposal_id'])->exists();
            if ($existingPartnerEntity) {
                return response()->json([
                    'message' => 'Partner entity already exists',
                    'error' => 'Partner entity already exists'
                ], 400);
            }
            $partnerEntity = PartnerEntity::findOrFail($id);
            $partnerEntity->update($validatedData);
            return response()->json([
                'message' => 'Partner entity updated successfully',
                'PartnerEntity' => new PartnerEntityResource($partnerEntity)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to update partner entity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function DeletePartnerEntity($id)
    {
        try {
            $partnerEntity = PartnerEntity::findOrFail($id);
            $partnerEntity->delete();
            return response()->json([
                'message' => 'Partner entity deleted successfully',
                'PartnerEntity' => new PartnerEntityResource($partnerEntity)
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to delete partner entity because not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
