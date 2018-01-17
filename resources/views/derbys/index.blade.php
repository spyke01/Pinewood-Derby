@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Pinewood Derby</h3></div>
                        <div class="panel-body">
                            <p>Welcome to Run A Derby! From here you can access your contestants, run heats and more. Click a link below or in the navbar above to get started.</p>

                            @can('Change Configuration')
                            <h3>Steps to Prepare a Derby</h3>
                            <div class="list-group list-group-badges-on-left">
                                <a href="{{ route('groups.index') }}" class="list-group-item">
                                    <span class="badge">1</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-object-group"></i> Add Groups</h4>
                                    <p class="list-group-item-text">Add all of your groups.</p>
                                </a>
                                <a href="{{ route('dens.index') }}" class="list-group-item">
                                    <span class="badge">2</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-home"></i> Add Dens</h4>
                                    <p class="list-group-item-text">Configure the dens.</p>
                                </a>
                                <a href="{{ route('scores-for-positions.index') }}" class="list-group-item">
                                    <span class="badge">Optional</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-sliders"></i> Change Scoring</h4>
                                    <p class="list-group-item-text">You can manage the score based on position here.</p>
                                </a>
                            </div>
                            @endcan

                            <h3>Steps to Run a Derby</h3>
                            <div class="list-group list-group-badges-on-left">
                                @can('Manage Contestants')
                                <a href="{{ route('contestants.index') }}" class="list-group-item">
                                    <span class="badge">1</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-address-book"></i> Add Contestants</h4>
                                    <p class="list-group-item-text">Add all of your contestants.</p>
                                </a>
                                @endcan
                                @can('Manage Heats')
                                <a href="{{ route('heats.index') }}" class="list-group-item">
                                    <span class="badge">2</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-thermometer-quarter"></i> Add Heats</h4>
                                    <p class="list-group-item-text">Configure the heats.</p>
                                </a>
                                @endcan
                                @can('Manage Runs')
                                <a href="{{ route('runs.index') }}" class="list-group-item">
                                    <span class="badge">3</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-car"></i> Enter Runs</h4>
                                    <p class="list-group-item-text">Manage individual runs.</p>
                                </a>
                                @endcan
                                <a href="{{ route('leader-board') }}" class="list-group-item">
                                    <span class="badge">4</span>
                                    <h4 class="list-group-item-heading"><i class="fa fa-btn fa-trophy"></i> View Leader Board</h4>
                                    <p class="list-group-item-text">View the results from the heats.</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection