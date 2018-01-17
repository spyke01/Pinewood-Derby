<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Den;
use App\Models\Derby;
use App\Models\Group;
use App\Models\Heat;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class DerbyController extends Controller
{
//	public function __construct()
//	{
//		$this->middleware(['auth', 'clearance']);
//	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('derbys.index' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leaderboard()
	{
		//list of movies in descending order of most releases.
		$contestants = DB::select( DB::raw( "
			SELECT 
			c.*,
			COALESCE( ( SELECT count(r.id) FROM `runs` r LEFT JOIN `heats` h ON r.heat_id = h.id WHERE contestant_id = c.id AND h.status = 'complete'  ), 0 ) AS numRuns,
			COALESCE( ( SELECT sum(sfp.score) FROM `runs` r LEFT JOIN `score_for_positions` sfp ON r.position = sfp.position WHERE r.contestant_id = c.id ), 0 ) AS score,
			COALESCE( ( SELECT d.picture FROM `dens` d WHERE c.den_id = d.id LIMIT 1 ), '' ) AS denPicture
			FROM `contestants` c
			ORDER BY
			score DESC
		" ) );
		$previousHeat = Heat::mostRecent()->with('group', 'runs', 'runs.contestant' )->first();
		$upNext = Heat::upcoming()->with('group', 'runs', 'runs.contestant' )->limit(5)->get();

		return view('derbys.leaderboard', compact( 'contestants', 'previousHeat', 'upNext') );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leaderboard_by_group()
	{
		$groups = array();
		$groupsInSystem = Group::orderBy('name')->get();
		$densInSystem = Den::orderBy('name')->get();

		foreach ( $groupsInSystem as $group ) {
			$groupContestants = DB::select( DB::raw( "
				SELECT 
				c.*,
				COALESCE( ( SELECT count(r.id) FROM `runs` r LEFT JOIN `heats` h ON r.heat_id = h.id WHERE contestant_id = c.id AND h.status = 'complete'  ), 0 ) AS numRuns,
				COALESCE( ( SELECT sum(sfp.score) FROM `runs` r LEFT JOIN `score_for_positions` sfp ON r.position = sfp.position WHERE r.contestant_id = c.id ), 0 ) AS score,
				COALESCE( ( SELECT d.picture FROM `dens` d WHERE c.den_id = d.id LIMIT 1 ), '' ) AS denPicture
				FROM `contestants` c
				WHERE c.group_id = " . intval( $group->id ) . "
				ORDER BY
				score DESC
			" ) );

			$groups[] = array(
				'name' => 'Group: ' . $group->name,
				'picture' => $group->picture,
				'contestants' => $groupContestants,
			);
		}

		foreach ( $densInSystem as $den ) {
			$denContestants = DB::select( DB::raw( "
				SELECT 
				c.*,
				COALESCE( ( SELECT count(r.id) FROM `runs` r LEFT JOIN `heats` h ON r.heat_id = h.id WHERE contestant_id = c.id AND h.status = 'complete'  ), 0 ) AS numRuns,
				COALESCE( ( SELECT sum(sfp.score) FROM `runs` r LEFT JOIN `score_for_positions` sfp ON r.position = sfp.position WHERE r.contestant_id = c.id ), 0 ) AS score,
				COALESCE( ( SELECT d.picture FROM `dens` d WHERE c.den_id = d.id LIMIT 1 ), '' ) AS denPicture
				FROM `contestants` c
				WHERE c.den_id = " . intval( $den->id ) . "
				ORDER BY
				score DESC
			" ) );

			$groups[] = array(
				'name' => 'Den: ' . $den->name,
				'picture' => $den->picture,
				'contestants' => $denContestants,
			);
		}
		//var_export($groups);

		return view('derbys.leaderboardbygroup', compact( 'groups') );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leaderboard_data()
	{
		//list of movies in descending order of most releases.
		$contestants = DB::select( DB::raw( "
			SELECT 
			c.*,
			COALESCE( ( SELECT count(r.id) FROM `runs` r LEFT JOIN `heats` h ON r.heat_id = h.id WHERE contestant_id = c.id AND h.status = 'complete'  ), 0 ) AS numRuns,
			COALESCE( ( SELECT sum(sfp.score) FROM `runs` r LEFT JOIN `score_for_positions` sfp ON r.position = sfp.position WHERE r.contestant_id = c.id ), 0 ) AS score,
			COALESCE( ( SELECT d.picture FROM `dens` d WHERE c.den_id = d.id LIMIT 1 ), '' ) AS denPicture
			FROM `contestants` c
			ORDER BY
			score DESC
		" ) );
		$previousHeat = Heat::mostRecent()->with('group', 'runs', 'runs.contestant' )->first();
		$upNext = Heat::upcoming()->with('group', 'runs', 'runs.contestant' )->limit(5)->get();

		$response = compact( 'contestants', 'previousHeat', 'upNext');

		return Response::json( $response );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function leaderboard_inner()
	{
		//list of movies in descending order of most releases.
		$contestants = DB::select( DB::raw( "
			SELECT 
			c.*,
			COALESCE( ( SELECT count(r.id) FROM `runs` r LEFT JOIN `heats` h ON r.heat_id = h.id WHERE contestant_id = c.id AND h.status = 'complete'  ), 0 ) AS numRuns,
			COALESCE( ( SELECT sum(sfp.score) FROM `runs` r LEFT JOIN `score_for_positions` sfp ON r.position = sfp.position WHERE r.contestant_id = c.id ), 0 ) AS score,
			COALESCE( ( SELECT d.picture FROM `dens` d WHERE c.den_id = d.id LIMIT 1 ), '' ) AS denPicture
			FROM `contestants` c
			ORDER BY
			score DESC
		" ) );
		$previousHeat = Heat::with('group', 'runs', 'runs.contestant' )->where( 'status', 'complete' )->orderBy('sequence', 'DESC')->orderBy('created_at', 'DESC')->first();
		$upNext = Heat::upcoming()->with('group', 'runs', 'runs.contestant' )->limit(5)->get();

		return view('derbys.partials.leaderboard', compact( 'contestants', 'previousHeat', 'upNext') );
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
