<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
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
		$groups = Group::with('contestants' )->get();

		return view('groups.index')->with('groups', $groups);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('groups.create' );
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

		$group = Group::create($request->only('name'));
		if ( $request->file('picture') ) {
			$group->picture = $request->file( 'picture' )
			                          ->store( 'images/groups' );
		}
		$group->save();

		return redirect()->route('groups.index')
		                 ->with('flash_message',
			                 'Group successfully added.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		return redirect('groups');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$group = Group::findOrFail($id);

		return view('groups.edit', compact('group' ));
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
		$group = Group::findOrFail($id);
		$this->validate($request, [
			'name'=>'required'
		]);

		$group->name = $request->input('name');

		if ( $request->file('picture') ) {
			$group->picture = $request->file( 'picture' )
			                          ->store( 'images/groups' );
		}

		$group->save();

		return redirect()->route('groups.index')
		                 ->with('flash_message',
			                 'Group successfully edited.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$group = Group::findOrFail($id);
		$group->delete();

		return redirect()->route('groups.index')
		                 ->with('flash_message',
			                 'Group successfully deleted.');
	}
}
