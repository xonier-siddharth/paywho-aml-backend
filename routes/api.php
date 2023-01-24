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


Route::post('/evaluate-transaction', [\App\Http\Controllers\Api\MonitorController::class, 'monitor_transaction_online']);
Route::post('/create-rule', [\App\Http\Controllers\Api\RulesController::class, 'createRule']);

// Route::get('/true-false', function () {
//     $cases = [
//         "",
//         "0",
//         "0.0",
//         "1",
//         "01",
//         "abc",
//         "true",
//         "false",
//         "null",
//         0,
//         0.1,
//         1,
//         1.1,
//         -42,
//         "NAN",
//         (float) "NAN",
//         NAN,
//         null,
//         true,
//         false,
//         [],
//         [""],
//         ["0"],
//         [0],
//         [null],
//         ["a"],
//     ];

//     echo "<pre>" . PHP_EOL;

//     foreach ($cases as $case) {
//         printf("%s -> %s" . PHP_EOL, str_pad(json_encode($case), 10, " ", STR_PAD_RIGHT), json_encode($case == true));
//     }
// });
