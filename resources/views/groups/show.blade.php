@extends('layouts.app')

@section('title', '| View Group')

@section('content')

<div class="container">
    
    <h1>{{ $group->title }}</h1>
    <hr>
    <p class="lead">{{ $group->body }} </p>
    <hr>
    {!! Form::open(['method' => 'DELETE', 'route' => ['groups.destroy', $group->id] ]) !!}
    <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
    @can('Edit Group')
    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-info" role="button"><i class="fa fa-check" ></i> Edit</a>
    @endcan
    @can('Delete Group')
    <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
    @endcan
    {!! Form::close() !!}

</div>

@endsection