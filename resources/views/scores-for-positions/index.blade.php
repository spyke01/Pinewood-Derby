@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-home"></i> Scores for Positions</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Position</th>
                    <th>Score</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if ( count($scoreForPositions) )
                    @foreach ($scoreForPositions as $scoreForPositions)
                        <tr>
                            <td>{{ $scoreForPositions->position }}</td>
                            <td>{{ $scoreForPositions->score }}</td>
                            <td>
                                <a href="{{ route('scores-for-positions.edit', $scoreForPositions->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['scores-for-positions.destroy', $scoreForPositions->id] ]) !!}
                                <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any scores for positions, you should add some.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        <a href="{{ route('scores-for-positions.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Score for Position</a>

    </div>
@endsection