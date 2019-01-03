<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\Den;
use App\Models\Group;
use Illuminate\Support\Facades\DB;

class ContestantController extends Controller
{
	public function __construct()
	{
		$this->middleware(['auth', 'clearance']);
	}

	static public function next_suitable( $options = array() ) {
		$exclude = (array) $options['exclude'];
		$exclude = array_map( function ( $contestant ) {
			return ( isset( $contestant->id ) ) ? intval( $contestant->id ) : intval( $contestant );
		}, $exclude );

		$lane = intval( $options['lane'] );
		$max_runs_per_contestant = env('LANES_ON_TRACK' );

		# select
		$query = Contestant::select( [
			'contestants.*',
			DB::raw( 'count(runs_with_chosen.id) AS heat_count_with_chosen' ),
			DB::raw( 'count(DISTINCT heats.id) AS heat_count' ),
			DB::raw( 'avg(runs.time) AS average_run_time' )
		] );
		$query = $query->leftJoin( 'runs', 'runs.contestant_id', '=', 'contestants.id' )
		               ->having( DB::raw( 'count(DISTINCT heats.id)' ), '<', DB::raw( $max_runs_per_contestant ) )
		               ->leftJoin( 'runs AS runs_in_lane', function ( $join ) use ( $lane ) {
				               $join->on( 'runs.contestant_id', '=', 'contestants.id' );
				               $join->on( 'runs.lane', '=', DB::raw( $lane ) );
			               } )->havingRaw( "count(runs_in_lane.id) = 0" )
		               ->leftJoin( 'heats', 'heats.id', '=',
			               'runs.heat_id' )
		               ->leftJoin( 'runs AS runs_with_chosen', function ( $join ) use ( $exclude ) {
				               $join->on( 'runs_with_chosen.heat_id', '=', 'heats.id' );
				               $join->whereIn( 'runs_with_chosen.contestant_id', $exclude );
			               } );

		# filter
		if ( count( $exclude ) ) 
			$query = $query->whereNotIn('contestants.id', $exclude);

		$query = $query->whereNull( 'contestants.retired' )
		               ->orWhere( 'contestants.retired', '=', DB::raw( 0 ) );

		# order
		$query = $query->groupBy( 'contestants.id' )
		               ->orderBy( 'heat_count_with_chosen' )
		               ->orderBy( 'heat_count' )
		               ->orderBy( 'average_run_time', 'DESC' )
		               ->orderBy( 'contestants.created_at' );

		//echo $query->toSql();
		if (isset ( $options['raw'] ) ) {
			return $query;
		} else {
			$query->first();
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$contestants = Contestant::byGroupAndDen()->get();
		return view('contestants.index')->with('contestants', $contestants);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$dens = Den::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );
		$groups = Group::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );
		return view('contestants.create', compact( 'dens', 'groups' ) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this->validate($request, [
			'name'=>'required',
			'group_id'=>'required'
		]);
		$formValues = $request->except('picture', 'car_picture' );

		// Handle checkboxes
		if ( isset( $formValues['car_passed_inspection'] ) ) {
			$formValues['car_passed_inspection'] = 1;
		} else {
			$formValues['car_passed_inspection'] = 0;
		}
		if ( isset( $formValues['exclude'] ) ) {
			$formValues['exclude'] = 1;
		} else {
			$formValues['exclude'] = 0;
		}
		if ( isset( $formValues['present'] ) ) {
			$formValues['present'] = 1;
		} else {
			$formValues['present'] = 0;
		}

		// Handle pictures
		if ( $request->file('picture') ) {
			$formValues['picture'] = $request->file( 'picture' )
			                               ->store( 'images/contestants' );
		}
		if ( $request->file('car_picture') ) {
			$formValues['car_picture'] = $request->file( 'car_picture' )
			                                   ->store( 'images/contestants' );
		}

		$contestant = Contestant::create($formValues);

		return redirect()->route('contestants.index')
		                 ->with('flash_message',
			                 'Contestant successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('contestants');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$contestant = Contestant::findOrFail($id);
		$dens = Den::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );
		$groups = Group::orderBy('name', 'ASC')->get()->pluck( 'name', 'id' );

		return view('contestants.edit', compact('contestant', 'dens', 'groups' ));
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
		$contestant = Contestant::findOrFail($id);
		$this->validate($request, [
			'name'=>'required',
			'group_id'=>'required'
		]);
		$formValues = $request->except('picture', 'car_picture' );

		// Handle checkboxes
		if ( isset( $formValues['car_passed_inspection'] ) ) {
			$formValues['car_passed_inspection'] = 1;
		} else {
			$formValues['car_passed_inspection'] = 0;
		}
		if ( isset( $formValues['exclude'] ) ) {
			$formValues['exclude'] = 1;
		} else {
			$formValues['exclude'] = 0;
		}
		if ( isset( $formValues['present'] ) ) {
			$formValues['present'] = 1;
		} else {
			$formValues['present'] = 0;
		}

		// Handle pictures
		if ( $request->file('picture') ) {
			$formValues['picture'] = $request->file( 'picture' )
			                                 ->store( 'images/contestants' );
		}
		if ( $request->file('car_picture') ) {
			$formValues['car_picture'] = $request->file( 'car_picture' )
			                                     ->store( 'images/contestants' );
		}

		$contestant->fill( $formValues );

		$contestant->save();

		return redirect()->route('contestants.index')
		                 ->with('flash_message',
			                 'Contestant successfully edited.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$contestant = Contestant::findOrFail($id);
		$contestant->delete();

		return redirect()->route('contestants.index')
		                 ->with('flash_message',
			                 'Contestant successfully deleted.');
	}
}
