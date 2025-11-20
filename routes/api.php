<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ActivityMethodologyController;
use App\Http\Controllers\ActivityMonitoringController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\BoardDeeController;
use App\Http\Controllers\CostController;
use App\Http\Controllers\ElementController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\PartnerEntityController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectDescriptionController;
use App\Http\Controllers\ProjectProposalController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStepController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');




Route::middleware('auth:sanctum')->group(function () {
    //Cost
    Route::prefix('costs')->group(function () {
        Route::get('/', [CostController::class, 'GetAllCosts']);
        Route::post('/', [CostController::class, 'AddCost']);
        Route::get('/{id}', [CostController::class, 'GetCost']);
        Route::put('/{id}', [CostController::class, 'UpdateCost']);
        Route::delete('/{id}', [CostController::class, 'DeleteCost']);
    });


    //bill
    Route::prefix('bills')->group(function () {
        Route::get('/', [BillController::class, 'GetBill']);
        Route::post('/', [BillController::class, 'AddBill']);
        Route::put('/{id}', [BillController::class, 'UpdateBill']);
        Route::delete('/{id}', [BillController::class, 'DeleteBill']);
    });
});


//Admin
Route::middleware(['auth:sanctum', 'CheckUserRole:admin'])->group(function () {

    //// user
    Route::get('getallusers', [UserController::class, 'GetAllUsers']);
    Route::get('getuser/{id}', [UserController::class, 'GetUser']);

    //// meeting
    Route::get('GetAllMeetings', [MeetingController::class, 'GetAllMettings']);
    Route::get('GetByIdMeeting/{id}', [MeetingController::class, 'GetMeeting']);
    Route::post('AddMeeting', [MeetingController::class, 'AddMeeting']);
    Route::put('UpdateMeeting/{id}', [MeetingController::class, 'UpdateMeeting']);
    Route::delete('DeleteMeeting/{id}', [MeetingController::class, 'DeleteMeeting']);
    Route::post('meetings/{id}/add-user', [MeetingController::class, 'addUser']);
    Route::post('meetings/{id}/remove-user', [MeetingController::class, 'removeUser']);
    // Route::get('getAllboardDees/{id}', [MeetingController::class, 'GetAllboardDees']);

    //// Board Dee
    Route::get('GetAll', [BoardDeeController::class, 'GetAllboard']);
    Route::post('Add', [BoardDeeController::class, 'AddBoard']);
    Route::get('GetById/{id}', [BoardDeeController::class, 'GetBoard']);
    Route::put('Edit/{id}', [BoardDeeController::class, 'UpdateBoard']);
    Route::delete('Delete/{id}', [BoardDeeController::class, 'DeleteBoard']);
        Route::get('GetAllByMeeting/{id}', [BoardDeeController::class, 'GetAllboardDees']);


    //// Project
    Route::get('GetAllProject', [ProjectController::class, 'GetallProject']);
    Route::post('AddProject', [ProjectController::class, 'AddProject']);
    Route::put('EditProject/{id}', [ProjectController::class, 'updateProjectInBoard']);
    Route::get('GetByIdProject/{id}', [ProjectController::class, 'GetProject']);
    Route::delete('DeleteProject/{id}', [ProjectController::class, 'DeleteProject']);

    //// Task
    Route::get('GetAllTask', [TaskController::class, 'GetAllTasks']);
    Route::post('AddTask', [TaskController::class, 'AddTask']);
    Route::get('GetByIdTask/{id}', [TaskController::class, 'GetTask']);
    Route::put('UpdateTask/{id}', [TaskController::class, 'UpdateTask']);
    Route::delete('DeleteTask/{id}', [TaskController::class, 'DeleteTask']);
    Route::get('GetAllProjectTasks/{id}/', [TaskController::class, 'GetAllTasksProject']);

    //// Tasks Steps
    Route::get('GetAllTaskStep', [TaskStepController::class, 'GetAllTaskSteps']);
    Route::post('AddTaskStep', [TaskStepController::class, 'AddTaskStep']);
    Route::get('GetByIdTaskStep/{id}', [TaskStepController::class, 'GetTaskStep']);
    Route::put('UpdateTaskStep/{id}', [TaskStepController::class, 'UpdateTaskStep']);
    Route::delete('DeleteTaskStep/{id}', [TaskStepController::class, 'DeleteTaskStep']);
    Route::get('GetAllTasksStepTask/{id}',[TaskStepController::class,'GetAllTasksStepProject']);


    //Element
    Route::get('elements', [ElementController::class, 'GetAllelemnts']);
    Route::post('elements', [ElementController::class, 'AddElement']);
    Route::get('elements/{id}', [ElementController::class, 'GetEelemnt']);
    Route::put('elements/{id}', [ElementController::class, 'UpdateElement']);
    Route::delete('elements/{id}', [ElementController::class, 'DeleteElement']);


    ////////////////////////////////////////////////////////////////////////////////////////////
    //// office 
    Route::get('offices', [OfficeController::class, 'GetAllOffices']);
    Route::post('offices', [OfficeController::class, 'AddOffice']);
    Route::get('offices/{id}', [OfficeController::class, 'GetOffice']);
    Route::put('offices/{id}', [OfficeController::class, 'UpdateOffice']);
    Route::delete('offices/{id}', [OfficeController::class, 'DeleteOffice']);

    ////project proposal
    Route::get('projectproposals', [ProjectProposalController::class, 'GetAllProjectProposals']);
    Route::post('projectproposals', [ProjectProposalController::class, 'AddProjectProposal']);
    Route::get('projectproposals/{id}', [ProjectProposalController::class, 'GetProjectProposal']);
    Route::put('projectproposals/{id}', [ProjectProposalController::class, 'UpdateProjectProposal']);
    Route::delete('projectproposals/{id}', [ProjectProposalController::class, 'DeleteProjectProposal']);

    ////objective
    Route::get('objectives', [ObjectiveController::class, 'GetAllObjectives']);
    Route::post('objectives', [ObjectiveController::class, 'AddObjective']);
    Route::get('objectives/{id}', [ObjectiveController::class, 'GetObjective']);
    Route::put('objectives/{id}', [ObjectiveController::class, 'UpdateObjective']);
    Route::delete('objectives/{id}', [ObjectiveController::class, 'DeleteObjective']);

    ////project description
    Route::get('projectdescriptions', [ProjectDescriptionController::class, 'GetAllProjectDescriptions']);
    Route::post('projectdescriptions', [ProjectDescriptionController::class, 'AddProjectDescription']);
    Route::get('projectdescriptions/{id}', [ProjectDescriptionController::class, 'GetProjectDescription']);
    Route::put('projectdescriptions/{id}', [ProjectDescriptionController::class, 'UpdateProjectDescription']);
    Route::delete('projectdescriptions/{id}', [ProjectDescriptionController::class, 'DeleteProjectDescription']);

    ////activity
    Route::get('activities', [ActivityController::class, 'GetAllActivities']);
    Route::post('activities', [ActivityController::class, 'AddActivity']);
    Route::get('activities/{id}', [ActivityController::class, 'GetActivity']);
    Route::put('activities/{id}', [ActivityController::class, 'UpdateActivity']);
    Route::delete('activities/{id}', [ActivityController::class, 'DeleteActivity']);

    ////partner entity
    Route::get('partnerentities', [PartnerEntityController::class, 'GetAllPartnerEntities']);
    Route::post('partnerentities', [PartnerEntityController::class, 'AddPartnerEntity']);
    Route::get('partnerentities/{id}', [PartnerEntityController::class, 'GetPartnerEntity']);
    Route::put('partnerentities/{id}', [PartnerEntityController::class, 'UpdatePartnerEntity']);
    Route::delete('partnerentities/{id}', [PartnerEntityController::class, 'DeletePartnerEntity']);

    ////activity methodology
    Route::get('activitymethodologies', [ActivityMethodologyController::class, 'GetAllActivityMethodologies']);
    Route::post('activitymethodologies', [ActivityMethodologyController::class, 'AddActivityMethodology']);
    Route::get('activitymethodologies/{id}', [ActivityMethodologyController::class, 'GetActivityMethodology']);
    Route::put('activitymethodologies/{id}', [ActivityMethodologyController::class, 'UpdateActivityMethodology']);
    Route::delete('activitymethodologies/{id}', [ActivityMethodologyController::class, 'DeleteActivityMethodology']);

    ////activity monitoring
    Route::get('activitymonitorings', [ActivityMonitoringController::class, 'GetAllActivityMonitorings']);
    Route::post('activitymonitorings', [ActivityMonitoringController::class, 'AddActivityMonitoring']);
    Route::get('activitymonitorings/{id}', [ActivityMonitoringController::class, 'GetActivityMonitoring']);
    Route::put('activitymonitorings/{id}', [ActivityMonitoringController::class, 'UpdateActivityMonitoring']);
    Route::delete('activitymonitorings/{id}', [ActivityMonitoringController::class, 'DeleteActivityMonitoring']);
});
