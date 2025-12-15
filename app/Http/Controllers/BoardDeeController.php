<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoardDeeRequest;
use App\Http\Requests\UpdateBoardDeeRequest;
use App\Http\Resources\BoardDeeResource;
use App\Http\Service\BoardDeeService;



class BoardDeeController extends Controller
{
    private BoardDeeService $boardDeeService;
    public function __construct(BoardDeeService $boardDeeService)
    {
        $this->boardDeeService = $boardDeeService;
    }
    public function GetAllboard()
    {
        $boards = $this->boardDeeService->getAllBoardDees();
        return BoardDeeResource::collection($boards);
    }

    public function AddBoard(StoreBoardDeeRequest $request)
    {
        $vailedated = $request->validated();
        $boardDee = $this->boardDeeService->AddBoardDee($vailedated);
        return response()->json([
            'message' => 'BoardDee created successfully',
            'data' => new BoardDeeResource($boardDee)
        ], 201);
    }

    public function GetBoard($id)
    {
        $boardDee = $this->boardDeeService->getBoardDeeById($id);
        return response()->json([
            'message' => $boardDee['message'],
            'boardDee' => $boardDee['success']
                ? new BoardDeeResource($boardDee['boardDee'])
                : null
        ], $boardDee['status']);
    }

    public function UpdateBoard(UpdateBoardDeeRequest $request, $id)
    {
        $boardDee = $this->boardDeeService->UpdateBoardDee($request->validated(), $id);
        return response()->json([
            'message' => $boardDee['message'],
            'boardDee' => $boardDee['success']
                ? new BoardDeeResource($boardDee['boardDee'])
                : null
        ], $boardDee['status']);
    }



    public function DeleteBoard($id)
    {
        $boardDee = $this->boardDeeService->DeleteBoardDee($id);
        return response()->json([
            'message' => $boardDee['message'],
            'boardDee' => $boardDee['success']
                ? new BoardDeeResource($boardDee['boardDee'])
                : null
        ], $boardDee['status']);
    }

    public function GetAllboardDees($id)
    {
        $boeardDees = $this->boardDeeService->getBoardDeesByMeetingId($id);
        return response()->json([
            'message' => $boeardDees['message'],
            'boardDees' => $boeardDees['success']
                ? BoardDeeResource::collection($boeardDees['boardDees'])
                : null
        ], $boeardDees['status']);
    }
}
