<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use Illuminate\Http\Request;
use App\Models\Den;
use App\Models\Group;
use App\Models\Heat;
use App\Models\Run;
use Excel;
use Illuminate\Support\Facades\DB;

class HeatController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'clearance']);
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function start_heat()
	{
		$heats = Heat::upcoming()->get();
		HeatController::fill_lineup();
		return view('heats.test', compact( 'heats') );
	}

	static public function fill_lineup()
	{
		Heat::upcomingincomplete()->delete();
		$races_to_queue       = env( 'RACES_TO_QUEUE_AT_A_TIME' );
		$contestants_per_heat = env( 'LANES_ON_TRACK' );

		for ( $i = 0; $i < $races_to_queue; $i++ ) {
			if ( Heat::upcoming()->count() >= $races_to_queue ) {
				break;
			}

			$chosen_contestants = array();
			for ( $x = 0; $x < $contestants_per_heat; $x ++ ) {
				$lane            = $x + 1;
				$next_contestant = ContestantController::next_suitable( array(
					'lane'    => $lane,
					'exclude' => array_values( $chosen_contestants )
				) );

				if ( $next_contestant ) {
					$chosen_contestants[ $lane ] = $next_contestant;
					break;
				}
			}

			if ( empty( $chosen_contestants ) ) {
				break;
			}

			HeatController::create_upcoming_from_contestants( $chosen_contestants );
		}
	}

	static public function create_upcoming_from_contestants( $contestants_by_lane )
	{
		$heat = Heat::create( array(
			'sequence' => HeatController::next_sequence(),
			'status' => 'upcoming',
		) );

		foreach ( $contestants_by_lane as $lane => $contestant ) {
			Run::create( array(
				'heat_id' => $heat->id,
				'contestant_id' => $contestant,
				'lane' => $lane,
			) );
		}
	}

	static public function next_sequence()
	{
		return Heat::orderBy('sequence', 'DESC')->first()->pluck('sequence');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$heats = Heat::with('group', 'runs', 'runs.contestant' )->get();
		//dd($heats);
		return view('heats.index')->with('heats', $heats);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('heats.create' );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function import()
	{
		$dens = Den::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );
		$groups = Group::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );

		return view('heats.import', compact( 'dens', 'groups' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		// See if we submitted an upload file
		if ( $request->file('import_file') ) {
			// Then we need to validate different items
			$this->validate($request, [
				'group_id'=>'required',
				'import_file'=>'required'
			]);

			// TODO: Build this logic
			$groupID = $request->input( 'group_id' );
			$importedFile = $request->file( 'import_file' )->getRealPath();
			$data = Excel::load($importedFile, function($reader) {})->get();
			$heatsToCreate = array();

			if ( ! empty( $data ) && $data->count() ) {
				$data = $data->toArray();

				foreach ( $data as $row ) {
					$heatsToCreate[ $row['race'] ] = array(
						'1' => (int)$row['lane_1'],
						'2' => (int)$row['lane_2'],
						'3' => (int)$row['lane_3'],
						'4' => (int)$row['lane_4'],
					);
				}
			}

			//dd($heatsToCreate);

			// Delete existing heat and run data for this group
			if ( $request->has('replace_heat') ) {
				DB::enableQueryLog();

				$deleteRuns = DB::table( 'runs' )->whereIn( 'heat_id', function ( $query ) use ( $groupID ) {
					  $query->select( 'id' )->from( 'heats' )->where( 'group_id', '=', $groupID );
				  } )->delete();
				$deleteHeats = Heat::where( 'group_id', $groupID )->delete();

				$laQuery = DB::getQueryLog();

				//dd($laQuery);

				# optionally disable the query log:
				DB::disableQueryLog();
				//die();
			}

			// Could be combined with above but I want the ability to debug without creating tons of inserts
			foreach ( $heatsToCreate as $sequence => $laneData ) {
				$heat = Heat::create([ 'sequence' => $sequence, 'group_id' => $groupID, 'status' => 'upcoming' ]);
				$heat->save();

				foreach ( $laneData as $lane => $contestantCarNumber ) {
					// Get contestant ID by group and car number
					$contestantID = Contestant::where( 'car_number', $contestantCarNumber )->where( 'group_id', $groupID )->get()->first();
					$contestantID = ( isset( $contestantID->id ) ) ? $contestantID->id : null;

					Run::create( array(
						'heat_id' => $heat->id,
						'contestant_id' => $contestantID,
						'lane' => $lane,
					) );

					// Un-retire a contestant if we just added more heats
					if ( $contestantID != null ) {
						$contestant = Contestant::findOrFail( $contestantID );
						$contestant->retired = 0;
						$contestant->save();
					}
				}
			};
		} else{
			// This is a standard store of a single heat item
			$this->validate($request, [
				'group_id'=>'required'
			]);

			$heat = Heat::create($request->all());
			$heat->save();
		}

		return redirect()->route('heats.index')
		                 ->with('flash_message',
			                 'Heat successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('heats');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$heat = Heat::findOrFail($id);

		return view('heats.edit', compact('heat' ));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$heat = Heat::findOrFail($id);
		$this->validate($request, [
			'name'=>'required'
		]);

		$heat->fill( $request->except('picture') );

		if ( $request->file('picture') ) {
			$heat->picture = $request->file( 'picture' )
			                        ->store( 'images/heats' );
		}

		$heat->save();

		return redirect()->route('heats.index')
		                 ->with('flash_message',
			                 'Heat successfully edited.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$heat = Heat::findOrFail($id);
		$heat->delete();

		return redirect()->route('heats.index')
		                 ->with('flash_message',
			                 'Heat successfully deleted.');
	}
}
