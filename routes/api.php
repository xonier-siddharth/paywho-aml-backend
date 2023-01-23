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

Route::post('/validate-transaction-test', [\App\Http\Controllers\Api\MonitorController::class, 'validate_transaction']);

Route::post('/create-rule', [\App\Http\Controllers\Api\RulesController::class, 'createRule']);

Route::prefix('debug')->group(function (){
    Route::get('/parse_rule',[DebugControllerr::class,'parseRule']);
});


Route::get('/test/rule/2',[RulesControllerr::class,'convertRule']);

Route::put('test/new/rule', function () {
    $ruel_data = [
        [
            "field_name" => "amount",
            "operator" => ">",
            "field_value" => "200000"
        ],
        [
            "field_name" => "account_number",
            "operator" => "=",
            "field_value" => "12345"
        ]
    ];

    $get_id = DB::table('monitor_rules')->insert(['code' => 'PW_001', 'title' => 'test_rule', 'target_object' => 'INDIVIDUAL', 'assessment_type' => 'Realtime', 'data' => json_encode($ruel_data), 'is_enabled' => true]);
    return $get_id;
});

Route::get('new/rule', function () {
//    transfer where created date is before 01012023 and
//    where destination account number is xxxxxxx
//    and where amount is more than 10000;

    $json_data = [
        "rule_name" => "Valid Transfer Check",
        "operation" => "flag_out",
        "data" => [
            "date" => [
                "before" => ['created_at' => 01012023],
                "after" => null
            ],
            "destination" => [
                "account_number" => 123123123123,
            ],
            "amount" => [
                "greater_than" => 10000
            ]
        ]
    ];

//        "name": "Billy",
//    "company": "Google",
//    "city": "London",
//    "event": "key-note-presentation-new-york-05-2016",
//    "responded": true,
//    "response": "I will be attending",
//    "managers": [
//        "Tom Jones",
//        "Joe Bloggs"
//    ],
//};

});

Route::post('/create-rule', [AMLRuleController::class, 'create_rule']);
Route::post('/evaluate-operation', [AMLRuleController::class, 'evaluate_operation']);


Route::post('/evaluate-transaction', [\App\Http\Controllers\Api\MonitorController::class, 'monitor_transaction']);

Route::post('/getRule', [\App\Http\Controllers\Api\RulesController::class, 'getRule']);

