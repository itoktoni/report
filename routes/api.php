<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('calendar', 'ReportScheduleController@getCalendar')->name('calendar');
Route::get('test', function(Request $request){
	$data = DB::table('item_linen')->where('item_linen_rfid', 'like', "%$request->search%")
	->limit(10)->get();
	$item = $data->map(function($item){
		return [
			'id' => $item->item_linen_rfid,
			'text' => $item->item_linen_rfid,
		];
	})->toArray();
	 return $item;
})->name('test');

// Route::get('linen_by_rs', );