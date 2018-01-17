@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-car"></i> Runs</h1>
        <hr>
        <a href="{{ route('start-next-run') }}" class="btn btn-success"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Start Next Race</a>
        <br /><br />
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Heat</th>
                    <th>Group</th>
                    <th>Status</th>
                    <th>Lane 1</th>
                    <th>Lane 2</th>
                    <th>Lane 3</th>
                    <th>Lane 4</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if ( count($heats) )
                    @foreach ($heats as $heat)
                        <tr>
                            <td>{{ $heat->id }}</td>
                            <td>{{ $heat->group->name }}</td>
                            <td>{{ $heat->status }}</td>
                            @foreach ($heat->runs as $run)
                                <td>
                                    @if ( isset( $run->contestant->name ) )
                                        {{$run->contestant->name}} (#{{$run->contestant->car_number}})
                                    @else
                                        Unknown
                                    @endif
                                    @if ( isset( $run->position ) )
                                            <span class="label label-success">{{$run->position}}</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="text-center">
                                @if ( $heat->status == 'complete' )
                                    <a href="{{ route('runs.edit', $heat->id) }}" class="btn btn-danger"><i class="fa fa-repeat" aria-hidden="true"></i> Redo</a>
                                @else
                                    <a href="{{ route('runs.edit', $heat->id) }}" class="btn btn-success"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Start the race!</a>
                                @endif
                                {{--<a href="{{ route('runs.edit', $run->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>--}}

                                {{--{!! Form::open(['method' => 'DELETE', 'route' => ['runs.destroy', $run->id] ]) !!}--}}
                                {{--<button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>--}}
                                {{--{!! Form::close() !!}--}}

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any Runs, you should add some by uploading the heat info.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        {{--<a href="{{ route('runs.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Run</a>--}}

    </div>
@endsection