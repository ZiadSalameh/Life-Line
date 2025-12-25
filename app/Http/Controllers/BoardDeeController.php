<?php

namespace App\Http\Controllers;

use App\DTOs\BoardDtos\BoardDto;
use App\Http\Requests\StoreBoardDeeRequest;
use App\Http\Requests\UpdateBoardDeeRequest;
use App\Http\Resources\BoardDeeResource;
use App\Http\Service\BoardDeeService;
use App\Models\BoardDee;
use Carbon\Carbon;

class BoardDeeController extends Controller
{

    public function __construct(private BoardDeeService $boardDeeService)
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
        $data = new BoardDto(
            board_no: $vailedated['board_no'],
            description: $vailedated['description'] ?? null,
            meeting_id: $vailedated['meeting_id'],
            voted: $vailedated['voted'] ?? null,
            boar_dee_date: isset($vailedated['boar_dee_date']) ? Carbon::parse($vailedated['boar_dee_date']) : null
        );
        $boardDee = $this->boardDeeService->AddBoardDee($data);
        return response()->json([
            'message' => 'BoardDee created successfully',
            'data' => new BoardDeeResource($boardDee['boardDee'])
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

    public function UpdateBoard($id, UpdateBoardDeeRequest $request)
    {
        $data = $request->validated();
        $dto = new BoardDto(
            board_no: $data['board_no'],
            description: $data['description'] ?? null,
            meeting_id: $data['meeting_id'],
            voted: $data['voted'] ?? null,
            boar_dee_date: isset($data['boar_dee_date']) ? Carbon::parse($data['boar_dee_date']) : null

        );
        $boardDee = $this->boardDeeService->UpdateBoardDee($id, $dto);
        return response()->json([
            'message' => $boardDee['message'],
            'boardDee' => $boardDee['success']
                ? new BoardDeeResource($boardDee['boardDee'])
                : null
        ], $boardDee['status']);
    }



    public function DeleteBoard($id)
    {
        $this->boardDeeService->DeleteBoardDee($id);
        return response()->json([
            'success' => true,
            'message' => 'Board deleted successfully'
        ], 200);
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
