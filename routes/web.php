<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Http\Request;
use App\Models\Contestant;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//Route::get('/home', 'HomeController@index');
//
Route::get('/', 'DerbyController@index')->name('home');
Route::get( 'derby/leader-board', 'DerbyController@leaderboard' )->name('leader-board');
Route::get( 'derby/leader-board-by-group', 'DerbyController@leaderboard_by_group' )->name('leader-board-by-group');
Route::get( 'derby/leader-board-data', 'DerbyController@leaderboard_data' )->name('leader-board-data');
Route::get( 'derby/leader-board-inner', 'DerbyController@leaderboard_inner' )->name('leader-board-inner');
Route::get( 'heats/import', 'HeatController@import' )->name('import-heats');
Route::get( 'heats/start-heat', 'HeatController@start_heat' )->name('start-heat');
Route::get( 'manage-data/purge', 'ManageDataController@purge' )->name('purge-data');
Route::get( 'runs/start-next', 'RunController@start_next' )->name('start-next-run');

Route::put('contestants/{contestant_id?}/passed-inspection', function( Request $request, $contestant_id ){
	$contestant = Contestant::find( $contestant_id );
	$contestant->car_passed_inspection = ( $request->input('car_passed_inspection') == 'true' ) ? 1 : 0;
	$contestant->save();

	return Response::json( $contestant );
});

Route::put('contestants/{contestant_id?}/exclude', function( Request $request, $contestant_id ){
	$contestant = Contestant::find( $contestant_id );
	$contestant->exclude = ( $request->input('exclude') == 'true' ) ? 1 : 0;
	$contestant->save();

	return Response::json( $contestant );
});

Route::put('contestants/{contestant_id?}/car-number', function( Request $request, $contestant_id ){
	$contestant = Contestant::find( $contestant_id );
	$contestant->car_number = $request->input('car_number');
	$contestant->save();

	return Response::json( $contestant );
});

Route::resource( 'contestants', 'ContestantController' );
Route::resource( 'dens', 'DenController' );
Route::resource( 'derby', 'DerbyController' );
Route::resource( 'groups', 'GroupController' );
Route::resource( 'heats', 'HeatController' );
Route::resource( 'manage-data', 'ManageDataController' );
Route::resource( 'permissions', 'PermissionController' );
Route::resource( 'posts', 'PostController' );
Route::resource( 'runs', 'RunController' );
Route::resource( 'scores-for-positions', 'ScoreForPositionController' );
Route::resource( 'roles', 'RoleController' );
Route::resource( 'users', 'UserController' );
