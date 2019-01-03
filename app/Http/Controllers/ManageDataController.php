<?php

namespace App\Http\Controllers;

use App\Models\Contestant;
use App\Models\Heat;
use App\Models\Run;
use Illuminate\Http\Request;

class ManageDataController extends Controller {
	public function __construct() {
		$this->middleware( [ 'auth', 'clearance' ] );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		return view( 'manage-data.index' );
	}

	/**
	 * Purge our run, heat, and contestant data .
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function purge() {
		Run::truncate();
		Heat::truncate();
		Contestant::truncate();

		return redirect()->route( 'manage-data.index' )
		                 ->with( 'flash_message',
			                 'Data successfully purged.' );
	}
}
