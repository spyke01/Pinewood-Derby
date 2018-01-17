@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-home"></i> Dens</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th>Pack or Troop Name</th>
                    <th>Leaders</th>
                    <th># of Contestants</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if ( count($dens) )
                    @foreach ($dens as $den)
                        <tr>
                            <td class="text-center">
                                @if ( !empty( $den->picture) )
                                    <img src="{{ asset( 'storage/' . $den->picture ) }}" class="img-responsive center-block max-w-100" alt="" />
                                @endif
                            </td>
                            <td>{{ $den->name }}</td>
                            <td>{{ $den->pack_name }}</td>
                            <td>{!! nl2br(e( $den->leaders )) !!}</td>
                            <td>
                                {{ $den->contestants()->inspected()->count() }}
                                of
                                {{ $den->contestants->count() }}
                                inspected
                            </td>
                            <td>
                                <a href="{{ route('dens.edit', $den->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['dens.destroy', $den->id] ]) !!}
                                <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any Dens, you should add some.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        <a href="{{ route('dens.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Den</a>

    </div>
@endsection