@extends('layouts.app')
@section('content')
    <div class="row p-b-1">
        <div class="col-md-10 col-md-offset-1">
            <div class="pull-right p-t-1">
                {{ Form::checkbox('leader_board_auto_refresh', 1, false, array( 'class' => 'leaderboardAutoRefreshToggle', 'data-toggle' => 'toggle', 'data-size' => 'small', 'data-on' => 'Yes', 'data-off' => 'No', 'data-onstyle' => 'success', 'data-offstyle' => 'default' ) ) }}
                <i class="fa fa-circle-o-notch fa-spin spinner hidden" ></i>
                Auto-Refresh
            </div>
        </div>
    </div>
    <div class="row p-b-1">
        <div id="leaderboardSpinner" class="col-md-10 col-md-offset-1 text-center">
            <h1><i class="fa fa-circle-o-notch fa-spin spinner" ></i></h1>
        </div>
    </div>
    <div id="leaderboard" class="row">

    </div>
@endsection