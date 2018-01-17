@extends('layouts.app')

@section('title', '| View Contestant')

@section('content')

<div class="container">
    
    <h1>{{ $contestant->title }}</h1>
    <hr>
    <p class="lead">{{ $contestant->body }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['contestants.destroy', $contestant->id] ]) !!}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Contestant')
    <a href="{{ route('contestants.edit', $contestant->id) }}" class="btn btn-info" role="button"><i class="fa fa-check" ></i> Edit</a>
    @endcan
    @can('Delete Contestant')
    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
    @endcan
    {!! Form::close() !!}

</div>

@endsection