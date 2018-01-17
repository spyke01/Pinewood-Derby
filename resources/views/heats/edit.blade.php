@extends('layouts.app')

@section('title', '| Edit Heat')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Edit Heat</h1>
            <hr>
            @include ('errors.list')
            {{ Form::model($heat, array('route' => array('heats.update', $heat->id), 'method' => 'PUT', 'files' => TRUE )) }}

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('pack_name', 'Pack or Troop Name') }}
                {{ Form::text('pack_name', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('leaders', 'Leaders') }}
                {{ Form::textarea('leaders', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('picture', 'Picture') }}
                {{ Form::file('picture', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection