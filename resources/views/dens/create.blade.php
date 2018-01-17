@extends('layouts.app')

@section('title', '| Create New Den')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>Create New Den</h1>
            <hr>
            {{-- @include ('errors.list') --}}

            {{-- Using the Laravel HTML Form Collective to create our form --}}
            {{ Form::open( array( 'route' => 'dens.store', 'files' => true ) ) }}

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', null, array('class' => 'form-control')) }}
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
                {{ Form::file('picture', null, array('class' => 'form-control')) }}
            </div>

            <div class="form-group">
                {{ Form::submit('Create Den', array('class' => 'btn btn-success btn-lg btn-block')) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection