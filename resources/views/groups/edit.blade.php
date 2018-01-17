@extends('layouts.app')

@section('title', '| Edit Group')

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            <h1>Edit Group</h1>
            <hr>
            @include ('errors.list')
            {{ Form::model($group, array('route' => array('groups.update', $group->id), 'method' => 'PUT', 'files' => TRUE )) }}
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', NULL, array('class' => 'form-control')) }}
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