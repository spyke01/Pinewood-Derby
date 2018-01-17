@extends('layouts.app')

@section('title', '| View Heat')

@section('content')

<div class="container">
    
    <h1>{{ $heat->title }}</h1>
    <hr>
    <p class="lead">{{ $heat->body }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['heats.destroy', $heat->id] ]) !!}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Heat')
    <a href="{{ route('heats.edit', $heat->id) }}" class="btn btn-info" role="button"><i class="fa fa-check" ></i> Edit</a>
    @endcan
    @can('Delete Heat')
    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
    @endcan
    {!! Form::close() !!}

</div>

@endsection