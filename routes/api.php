<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Book;
use App\Http\Controllers\BookController;

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


// Route::middleware('throttle:60,1')->get('books', 'BookController@index');
// Route::middleware('throttle:60,1')->get('books/{id}', 'BookController@show');
// Route::middleware('throttle:60,1')->post('books', 'BookController@store');
// Route::middleware('throttle:60,1')->put('books/{id}', 'BookController@update');
// Route::middleware('throttle:60,1')->delete('books/{id}', 'BookController@delete');

Route::post('login', 'AuthController@login');
Route::post('signup', 'AuthController@signup');

Route::group([
    'prefix' => 'books',
    'middleware' => ['api.auth','throttle:ip-address','throttle:60,1']
], function () {
	Route::get('/', 'BookController@index')->middleware('throttle:user-session');
	Route::get('/{id}', 'BookController@show');
	Route::post('', 'BookController@store');
	Route::put('/{id}', 'BookController@update');
	Route::delete('/{id}', 'BookController@delete');
});