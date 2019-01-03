@extends('layouts.app')

@if ( isset( $heat->id ) )
    @section( 'title', '| Edit Run for Heat #' . $heat->id )
@else
    @section( 'title', '| No Runs Available' )
@endif

@section('content')
    <div class="row">

        <div class="col-md-8 col-md-offset-2">

            @if ( isset( $heat->id ) )
                <h1>Edit Run for Heat #{{ $heat->id }}</h1>
                <hr>
                @include ('errors.list')
                {{ Form::model($heat, array('route' => array('runs.update', $heat->id), 'id' => 'heatEntryForm', 'method' => 'PUT', 'files' => TRUE )) }}
                {{ Form::hidden('redirectTo', $redirectTo) }}

                <div class="form-group">
                    {{ Form::label('heat', 'Heat') }}
                    <p class="form-control-static">{{ $heat->id }}</p>
                </div>

                <div class="form-group">
                    {{ Form::label('group', 'Group') }}
                    <p class="form-control-static">{{ $heat->group->name }}</p>
                </div>

                @foreach ($heat->runs as $run)
                    <div class="form-group">
                        <label for="lane_position[{{$run->lane}}]">
                            Lane {{$run->lane}} Results for

                            @if ( isset( $run->contestant->name ) )
                                {{$run->contestant->name}} (#{{$run->contestant->car_number}})
                            @else
                                Unknown
                            @endif
                        </label>

                        {{ Form::number('lane_position[' . $run->lane . ']', $run->position, array('class' => 'form-control')) }}
                    </div>
                @endforeach

                <div class="form-group">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary')) }}
                </div>

                {{ Form::close() }}
            @else
                <div class="alert alert-info">There are no more runs to run!</div>
            @endif
        </div>
    </div>

@endsection