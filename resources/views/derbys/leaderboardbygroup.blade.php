@extends('layouts.app')
@section('content')
    <div id="leaderboard-by-group" class="row">
        @foreach ($groups as $group)
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if ( !empty( $group['picture'] ) )
                            <img src="{{ asset( 'storage/' . $group['picture'] ) }}" class="img-responsive inline-block max-w-60 pull-right" alt="" />
                        @endif
                        <h3>
                            Leader Board for {{ $group['name'] }}
                        </h3>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Position</th>
                                <th class="hidden-xs">Contestant</th>
                                <th>Car</th>
                                <th>Races</th>
                                <th>Total Score</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- Loop thru contestants --}}
                            @if ( count( $group['contestants'] ) )
                                @foreach ($group['contestants'] as $contestant)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td class="hidden-xs">
                                            {{ $contestant->name }}
                                            @if ( !empty( $contestant->denPicture) )
                                                <img src="{{ asset( 'storage/' . $contestant->denPicture ) }}" class="img-responsive inline-block max-w-30 pull-right" alt="" />
                                            @endif
                                        </td>
                                        <td>{{$contestant->car_name}} (#{{$contestant->car_number}})</td>
                                        <td>{{ $contestant->numRuns }}</td>
                                        <td>
                                            {{ $contestant->score }}
                                            @if ( $contestant->retired )
                                                <span class="btn btn-success btn-xs pull-right"><i class="fa fa-check" aria-hidden="true"></i> FINAL</span>
                                            @else
                                                <span class="btn btn-danger btn-xs pull-right">Still Racing</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection