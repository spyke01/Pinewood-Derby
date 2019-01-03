@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-cogs"></i> Manage Data</h1>
        <hr>
        <p>Below you will find tools that allow you to manage the data within the system, including purging data.</p>

        <div class="panel panel-default">
            <div class="panel-heading"><h3><i class="fa fa-database"></i> Purge Data</h3></div>
            <div class="panel-body">
                <p>Clicking the button below will purge all data in the system related to contestants, heats, and runs.</p>
                <p>Den, Groups, and other items are not affected.</p>
                <h3>WARNING - This action is irreversible!</h3>

                <a href="{{ route('purge-data') }}" class="btn btn-danger btn-large confirmAction" data-actionText="purge the system"><i class="fa fa-times"></i> Purge Data</a>
            </div>
        </div>
    </div>
@endsection