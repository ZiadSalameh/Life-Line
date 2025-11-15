<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Models\Cost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CostController extends Controller
{

     public function GetAllCosts()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $costs = Cost::with('element')->get();
        return response()->json($costs,200);
    }
    public function AddCost(StoreCostRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validated = $request->validated();
        $cost = Cost::create($validated);

        return response()->json($cost, 201);
    }

    public function GetCost($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cost = Cost::with('element')->find($id);
        return $cost ? response()->json($cost) : response()->json(['message' => 'Not found'], 404);
    }

    public function UpdateCost(UpdateCostRequest $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cost = Cost::find($id);
        if (!$cost) return response()->json(['message' => 'Not found'], 404);

         $validated = $request->validated();
        $cost->update($validated);
        return response()->json(['messeage'=>'Update successfully',$cost],200);
    }


    public function DeleteCost($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cost = Cost::find($id);
        if (!$cost) return response()->json(['message' => 'Not found'], 404);

        $cost->delete();
        return response()->json(['message' => 'Deleted']);
    }







}
