<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Den;

class DenController extends Controller
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
		$dens = Den::with('contestants' )->get();

		return view('dens.index')->with('dens', $dens);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('dens.create' );
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

		$den = Den::create($request->except('picture'));
		if ( $request->file('picture') ) {
			$den->picture = $request->file( 'picture' )
			                          ->store( 'images/dens' );
		}
		$den->save();

		return redirect()->route('dens.index')
		                 ->with('flash_message',
			                 'Den successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('dens');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$den = Den::findOrFail($id);

		return view('dens.edit', compact('den' ));
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
		$den = Den::findOrFail($id);
		$this->validate($request, [
			'name'=>'required'
		]);

		$den->fill( $request->except('picture') );

		if ( $request->file('picture') ) {
			$den->picture = $request->file( 'picture' )
			                          ->store( 'images/dens' );
		}

		$den->save();

		return redirect()->route('dens.index')
		                 ->with('flash_message',
			                 'Den successfully edited.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$den = Den::findOrFail($id);
		$den->delete();

		return redirect()->route('dens.index')
		                 ->with('flash_message',
			                 'Den successfully deleted.');
	}
}
