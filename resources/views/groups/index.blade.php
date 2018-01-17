@extends('layouts.app')
@section('content')
    <div class="col-lg-10 col-lg-offset-1">
        <h1><i class="fa fa-object-group"></i> Groups</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Picture</th>
                    <th>Name</th>
                    <th># of Contestants</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                @if ( count($groups) )
                    @foreach ($groups as $group)
                        <tr>
                            <td class="text-center">
                                @if ( !empty( $group->picture) )
                                    <img src="{{ asset( 'storage/' . $group->picture ) }}" class="img-responsive center-block max-w-100" alt="" />
                                @endif
                            </td>
                            <td>{{ $group->name }}</td>
                            <td>
                                {{ $group->contestants()->inspected()->count() }}
                                of
                                {{ $group->contestants->count() }}
                                inspected
                            </td>
                            <td>
                                <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;"><i class="fa fa-check" ></i> Edit</a>

                                {!! Form::open(['method' => 'DELETE', 'route' => ['groups.destroy', $group->id] ]) !!}
                                <button class="btn btn-danger" type="submit"><i class="fa fa-times" ></i> Delete</button>
                                {!! Form::close() !!}

                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="100%" class="warning text-center">
                            You do not have any Groups, you should add some.
                        </td>
                    </tr>
                @endif
                </tbody>

            </table>
        </div>

        <a href="{{ route('groups.create') }}" class="btn btn-success"><i class="fa fa-plus" ></i> Add Group</a>

    </div>
@endsection