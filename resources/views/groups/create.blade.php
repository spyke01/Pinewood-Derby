@extends('layouts.app')

@section('title', '| Create New Group')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Group</h1>
            <hr>
            {{-- @include ('errors.list') --}}

            {{-- Using the Laravel HTML Form Collective to create our form --}}
            {{ Form::open( array( 'route' => 'groups.store', 'files' => TRUE ) ) }}

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::label('picture', 'Picture') }}
                {{ Form::file('picture', NULL, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Create Group', array('class' => 'btn btn-success btn-lg btn-block')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection