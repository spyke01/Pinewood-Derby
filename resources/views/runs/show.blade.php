@extends('layouts.app')

@section('title', '| View Run')

@section('content')

<div class="container">
    
    <h1>{{ $run->title }}</h1>
    <hr>
    <p class="lead">{{ $run->body }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['runs.destroy', $run->id] ]) !!}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Run')
    <a href="{{ route('runs.edit', $run->id) }}" class="btn btn-info" role="button"><i class="fa fa-check" ></i> Edit</a>
    @endcan
    @can('Delete Run')
    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
    @endcan
    {!! Form::close() !!}

</div>

@endsection