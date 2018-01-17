<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contestant;
use App\Models\Heat;
use App\Models\Run;

class RunController extends Controller
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
	public function index()
	{
		$heats = Heat::orderBy('status')->orderBy('id')->with('group', 'runs', 'runs.contestant' )->get();
		//dd($heats);
		return view('runs.index')->with('heats', $heats);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('runs.create' );
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
			'name'=>'required'
		]);

		$run = Run::create($request->except('picture'));
		if ( $request->file('picture') ) {
			$run->picture = $request->file( 'picture' )
			                        ->store( 'images/runs' );
		}
		$run->save();

		return redirect()->route('runs.index')
		                 ->with('flash_message',
			                 'Run successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('runs');
	}

	/**
	 * Start the heat that is next in line.
	 */
	public function start_next()
	{
		$heat = Heat::upcoming()->with('group', 'runs', 'runs.contestant' )->first();
		$redirectTo = 'start-next-run';

		return view('runs.edit', compact('heat', 'redirectTo' ));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$heat = Heat::with('group', 'runs', 'runs.contestant' )->findOrFail($id);
		$redirectTo = 'runs.index';

		return view('runs.edit', compact('heat', 'redirectTo' ));
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
		// Make sure we specified a heat
		$heat = Heat::findOrFail($id);
		$this->validate($request, [
			'lane_position'=>'required'
		]);
		$contestsToCheckForRetirement = array();

		// We now need to loop through out positions and update them
		foreach ( $request->input('lane_position') as $laneID ) {
			$run = Run::with('contestant')->where('heat_id', '=', $id)->where('lane', '=', $laneID );

			// Debugging
			//echo $run->toSql() . " for heat $id and lane $laneID";

			$run = $run->firstOrFail();

			// Save contestants for a retirement check
			$contestsToCheckForRetirement[] = $run->contestant->id;

			// Finally save the run
			$run->position = $request->input('lane_position.' . $laneID );
			$run->save();
		}

		$heat->status = 'complete';
		$heat->save();

		// Mark drivers as retired if necessary
		foreach ( $contestsToCheckForRetirement as $contestantID ) {
			$q = Run::selectRaw( 'count(runs.id) as runsLeft' )
			        ->join( 'heats', 'heats.id', '=', 'runs.heat_id' )
			        ->where( 'heats.status', '=', 'upcoming' )
			        ->where( 'runs.contestant_id', '=', $contestantID )
			        ->first();
			//echo $q->toSql() . " for heat $id and contestant {$contestantID}";
			$runsLeft = $q->runsLeft;

			if ( $runsLeft == 0 ) {
				$contestant          = Contestant::findOrFail( $contestantID );
				$contestant->retired = TRUE;
				$contestant->save();
			}
		}

		if ( $request->has('redirectTo') ) {
			return redirect()->route($request->input('redirectTo'))->with('flash_message', 'Successfully updated run ' . intval( $id ) . '.');
		} else {
			return redirect()->route('runs.index')->with('flash_message', 'Successfully updated run ' . intval( $id ) . '.');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$run = Run::findOrFail($id);
		$run->delete();

		return redirect()->route('runs.index')
		                 ->with('flash_message',
			                 'Run successfully deleted.');
	}
}
