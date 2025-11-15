<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardDeeRequest;
use App\Http\Requests\UpdateBoardDeeRequest;
use App\Http\Resources\BoardDeeResource;
use App\Http\Resources\MeetingResource;
use App\Models\BoardDee;
use App\Models\Meeting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoardDeeController extends Controller
{
    public function GetAllboard()
    {
      
        $boards = BoardDee::with('meeting')->get();
        return BoardDeeResource::collection($boards);
    }


    public function AddBoard(StoreBoardDeeRequest $request)
    {
        $vailedated = $request->validated();
        $existdata = BoardDee::where('meeting_id', $vailedated['meeting_id'])->where('board_no', $vailedated['board_no'])->exists();
        if ($existdata) {
            return response()->json([
                'message' => 'BoardDee already exists',
                'error' => 'BoardDee already exists',
            ], 400);
        }
        $boardDee = BoardDee::create($vailedated);
        return response()->json([
            'message' => 'BoardDee created successfully',
            'data' => new BoardDeeResource($boardDee)
        ], 201);
    }

    public function GetBoard($id)
    {
        try {
            $boardDee = BoardDee::with('meeting')->findOrFail($id);
            return new BoardDeeResource($boardDee);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    public function UpdateBoard(UpdateBoardDeeRequest $request, $id)
    {
        try{
            $boardDee = BoardDee::findOrFail($id);
            $vailedated = $request->validated();
            $boardDee->update($vailedated);
            return response()->json([
                'message' => 'BoardDee updated successfully',
                'data' => new BoardDeeResource($boardDee)
            ], 200);
        }catch(ModelNotFoundException $e){
            return response()->json([
                'message' => 'Not found',
                'error' => $e->getMessage(),
            ], 404);
        }
    }



    public function DeleteBoard($id)
    {
       try{
        $boardDee = BoardDee::with('meeting')->findOrFail($id);
        $boardDee->delete();
        return response()->json([
            'message' => 'BoardDee deleted successfully',
            'data' => new BoardDeeResource($boardDee)
        ], 200);
       }catch(ModelNotFoundException $e){
        return response()->json([
            'message' => 'Not found',
            'error' => $e->getMessage(),
        ], 404);
       }
    }

     public function GetAllboardDees($id)
    {
        try {
            $meeting = Meeting::with('boardDees')->findOrFail($id);
            if ($meeting->boardDees->isEmpty()) {
                return response()->json([
                    'message' => 'No board dees found for this meeting'
                ], 404);
            }
            return response()->json([
                'message' => 'Board dees retrieved successfully',
                'boards' => BoardDeeResource::collection($meeting->boardDees)
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Meeting not found'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'An error occurred while processing your request',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
