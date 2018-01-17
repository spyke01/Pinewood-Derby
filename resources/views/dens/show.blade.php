@extends('layouts.app')

@section('title', '| View Den')

@section('content')

<div class="container">
    
    <h1>{{ $den->title }}</h1>
    <hr>
    <p class="lead">{{ $den->body }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['dens.destroy', $den->id] ]) !!}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Den')
    <a href="{{ route('dens.edit', $den->id) }}" class="btn btn-info" role="button"><i class="fa fa-check" ></i> Edit</a>
    @endcan
    @can('Delete Den')
    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
    @endcan
    {!! Form::close() !!}

</div>

@endsection