<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Http\Requests\UpdateBillRequest;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
     public function GetBill()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $bills = Bill::with('cost.element')->get();
        return response()->json($bills);
    }

    public function AddBill(StoreBillRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if (Bill::where('cost_id', $request->cost_id)->exists())
        {
            return response()->json([
                'message' => 'The bill exists befor for this cost  '
            ], 422);
        }

        $validated = $request->validated();
        $bill = Bill::create($validated);

        return response()->json($bill, 201);
    }


    public function UpdateBill(UpdateBillRequest $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $bill = Bill::find($id);
        if (!$bill) return response()->json(['message' => 'Not found'], 404);

        $validated = $request->validated();

        if (isset($validated['cost_id']) && $validated['cost_id'] != $bill->cost_id)
        {
            return response()->json([
                'message' => 'Cannot change cost association. Use delete and create new bill instead.'
            ], 422);
        }

        $bill->update($validated);
        return response()->json(['message'=>'Updated successfully',$bill],200);
    }


    public function DeleteBill($id)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $bill = Bill::find($id);
        if (!$bill) return response()->json(['message' => 'Not found'], 404);

        $bill->delete();
        return response()->json(['message' => 'Deleted'],200);
    }


}
