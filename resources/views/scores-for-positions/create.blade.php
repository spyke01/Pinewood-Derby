@extends('layouts.app')

@section('title', '| Create New Score for Position')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Score for Position</h1>
            <hr>
            {{-- @include ('errors.list') --}}

            {{-- Using the Laravel HTML Form Collective to create our form --}}
            {{ Form::open( array( 'route' => 'scores-for-positions.store' ) ) }}

            <div class="form-group">
                {{ Form::label('position', 'Position') }}
                {{ Form::number('position', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('score', 'Score') }}
                {{ Form::number('score', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Create Score for Position', array('class' => 'btn btn-success btn-lg btn-block')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection