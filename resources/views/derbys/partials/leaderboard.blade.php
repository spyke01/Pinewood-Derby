<div class="col-md-6 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>
                Leader Board
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
                @if ( count($contestants) )
                    @foreach ($contestants as $contestant)
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td class="hidden-xs">
                                {{ filterNameForPublic( $contestant->name ) }}
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
<div class="col-md-4">
    @if ( count($previousHeat) )
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>
                Previous Heat
                @can('Manage Runs')
                    <a href="{{ route('runs.edit', $previousHeat->id) }}" class="btn btn-danger btn-sm pull-right"><i class="fa fa-repeat" aria-hidden="true"></i> Redo</a>
                @endcan
            </h3>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="hidden-xs">Heat</th>
                        <th>Lane 1</th>
                        <th>Lane 2</th>
                        <th>Lane 3</th>
                        <th>Lane 4</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="hidden-xs">{{ $previousHeat->id }}</td>
                        @foreach ($previousHeat->runs as $run)
                            <td>
                                @if ( isset( $run->contestant->name ) )
                                    {{ filterNameForPublic( $run->contestant->name ) }} (#{{$run->contestant->car_number}})
                                @else
                                    Unknown
                                @endif
                                @if ( isset( $run->position ) )
                                    <span class="label label-success">{{$run->position}}</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    @if ( count($upNext) )
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>
                Up Next
                @can('Manage Runs')
                    <a href="{{ route('start-next-run') }}" class="btn btn-success btn-sm pull-right"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Start Next Race</a>
                @endcan
            </h3>
        </div>
        <div class="panel-body table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="hidden-xs">Heat</th>
                    <th>Lane 1</th>
                    <th>Lane 2</th>
                    <th>Lane 3</th>
                    <th>Lane 4</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($upNext as $heat)
                <tr>
                    <td class="hidden-xs">{{ $heat->id }}</td>
                    @foreach ($heat->runs as $run)
                        <td>
                            @if ( isset( $run->contestant->name ) )
                                {{ filterNameForPublic( $run->contestant->name ) }} (#{{$run->contestant->car_number}})
                            @else
                                Unknown
                            @endif
                        </td>
                    @endforeach
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>