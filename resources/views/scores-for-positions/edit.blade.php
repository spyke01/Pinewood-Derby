@extends('layouts.app')

@section('title', '| Edit Score for Position')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Edit Score for Position</h1>
            <hr>
            @include ('errors.list')
            {{ Form::model($scoreForPosition, array('route' => array('scores-for-positions.update', $scoreForPosition->id), 'method' => 'PUT' )) }}

            <div class="form-group">
                {{ Form::label('position', 'Position') }}
                {{ Form::number('position', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('score', 'Score') }}
                {{ Form::number('score', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection