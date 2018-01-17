@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-thermometer-quarter"></i> Heats</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Group</th>
                    <th>Contestants</th>
                    {{--<th></th>--}}
                </tr>
                </thead>

                <tbody>
                @if ( count($heats) )
                    @foreach ($heats as $heat)
                        <tr>
                            <td>{{ $heat->id }}</td>
                            <td>{{ $heat->group->name }}</td>
                            <td>
                                @php
                                    $contestants = '';

                                foreach( $heat->runs as $run ) {
                                    if ( isset( $run->contestant->name ) ) {
                                        $contestants .= "{$run->contestant->name} (#{$run->contestant->car_number}), ";
                                    } else {
                                        $contestants .= "Unknown, ";
                                    }
                                }
                                echo rtrim( $contestants, ', ' );
                                @endphp
                            </td>
                            {{--<td>--}}
                                {{--<a href="{{ route('heats.edit', $heat->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>--}}

                                {{--{!! Form::open(['method' => 'DELETE', 'route' => ['heats.destroy', $heat->id] ]) !!}--}}
                                {{--<button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>--}}
                                {{--{!! Form::close() !!}--}}

                            {{--</td>--}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any heats, you should import them.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        <a href="{{ route('import-heats') }}" class="btn btn-success"><i class="fa fa-upload" ></i> Import Heats</a>

    </div>
@endsection