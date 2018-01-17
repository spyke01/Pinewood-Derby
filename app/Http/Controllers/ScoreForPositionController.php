<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ScoreForPosition;

class ScoreForPositionController extends Controller
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
		$scoreForPositions = ScoreForPosition::all();

		return view('scores-for-positions.index')->with('scoreForPositions', $scoreForPositions);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('scores-for-positions.create' );
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
			'position'=>'required',
			'score'=>'required'
		]);

		$scoreForPosition = ScoreForPosition::create($request->all());

		return redirect()->route('scores-for-positions.index')
		                 ->with('flash_message',
			                 'ScoreForPosition successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('scoreForPositions');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$scoreForPosition = ScoreForPosition::findOrFail($id);

		return view('scores-for-positions.edit', compact('scoreForPosition' ));
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
		$scoreForPosition = ScoreForPosition::findOrFail($id);
		$this->validate($request, [
			'position'=>'required',
			'score'=>'required'
		]);

		$scoreForPosition->fill( $request->all() );
		$scoreForPosition->save();

		return redirect()->route('scores-for-positions.index')
		                 ->with('flash_message',
			                 'ScoreForPosition successfully edited.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$scoreForPosition = ScoreForPosition::findOrFail($id);
		$scoreForPosition->delete();

		return redirect()->route('scores-for-positions.index')
		                 ->with('flash_message',
			                 'ScoreForPosition successfully deleted.');
	}
}
