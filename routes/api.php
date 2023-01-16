<?php

use App\Http\Controllers\AMLRuleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/create-rule', [AMLRuleController::class, 'create_rule']);
Route::post('/evaluate-operation', [AMLRuleController::class, 'evaluate_operation']);


Route::post('/evaluate-transaction', [\App\Http\Controllers\Api\MonitorController::class, 'monitor_transaction']);


Route::post('/getRule', [\App\Http\Controllers\Api\RulesController::class, 'validateTransaction']);
Route::post('/createRule', [\App\Http\Controllers\Api\RulesController::class, 'createRule']);
