<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Models\Division;
use App\Models\District;
use App\Models\Report;
use App\Models\Unit;

use App\Http\Controllers\ReportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::get('/div-rep/{name}', function ($name) {
//     $division = Division::where('name', 'like', '%' . $name)->get()->first();
//     return $division->reports;
// });

// Route::get('/dis-rep/{name}', function ($name) {
//     $district = District::where('name', 'like', '%' . $name)->get()->first();
//     return $district->reports;
// });

// Route::get('/unit-rep/{name}', function ($name) {
//     $unit = Unit::where('name', 'like', '%' . $name)->get()->first();
//     return $unit->reports;
// });

// Route::resource('reports', ReportController::class);

// Public Routes
Route::post('/search-user', [AuthController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/divisions', function () {
    return Division::all();
});

Route::get('/districts-division/{id}', function ($id) {
    $division = Division::find($id);
    return $division->districts;
});

Route::get('/units-district/{id}', function ($id) {
    $district = District::find($id);
    return $district->units;
});

// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/new-users', [AuthController::class, 'getUnverifiedUsers']);
    Route::post('/verify-user', [AuthController::class, 'verifyUser']);

    Route::post('/reports', [ReportController::class, 'store']);
    Route::put('/reports/{id}', [ReportController::class, 'update']);
    Route::delete('/reports/{id}', [ReportController::class, 'destroy']);

    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{id}', [ReportController::class, 'show']);
    Route::get('/reports/search/{id}', [ReportController::class, 'search']);

    Route::get('/report-division', [ReportController::class, 'reportByDivision']);
    Route::get('/report-division-single', [ReportController::class, 'reportBySingleDivision']);
    Route::get('/report-total', [ReportController::class, 'totalReport']);
    Route::get('/report-total-division', [ReportController::class, 'totalReportByDivision']);

    Route::get('/report-today-short', [ReportController::class, 'totalShortReportToday']);
    Route::get('/report-today-detailed', [ReportController::class, 'totalDetailedReportToday']);
    Route::get('/report-not-sent', [ReportController::class, 'reportNotSentToday']);

    Route::get('/members/{unitId}', [DataController::class, 'getMembersByUnit']);
    Route::post('/members/{unitId}', [DataController::class, 'updateMembersByUnit']);

    Route::post('/logout', [AuthController::class, 'logout']);
});
